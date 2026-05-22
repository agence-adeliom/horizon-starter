<?php

declare(strict_types=1);

namespace App\Hooks;

use Adeliom\HorizonTools\Database\QueryBuilder;
use Adeliom\HorizonTools\Hooks\AbstractHook;

class LastContentSeenHook extends AbstractHook
{
    public const string KEY_TO_KEEP = 'toKeep';
    private const string COOKIE_NAME = 'lastSeen';
    private const int COOKIE_DURATION = 3600;

    public function init(): void
    {
        if (empty(self::getPostTypesToMonitor())) {
            return;
        }

        add_filter('the_content', [$this, 'saveLastSeen']);
    }

    public static function getPostTypesToMonitor(): array
    {
        // return [
        //     'page' => [
        //         self::KEY_TO_KEEP => 3,
        //     ],
        // ];

        return [];
    }

    public static function getLastSeenByPostType(string $postType): array
    {
        $results = [];

        $postTypesData = self::getPostTypesToMonitor();

        if (!in_array($postType, array_keys($postTypesData))) {
            throw new \Exception('Unhandled post type: ' . $postType);
        }

        $qb = new QueryBuilder()->postType($postType)->perPage($postTypesData[$postType][self::KEY_TO_KEEP]);

        switch (true) {
            case !is_admin():
                $savedData = self::getSavedData(postType: $postType);

                if (isset($savedData[$postType]) && is_array($savedData[$postType])) {
                    $ids = array_map('intval', $savedData[$postType]);
                    $results = $qb->whereIdIn(ids: $ids)->get();

                    if (!empty($results)) {
                        // Order results like IDs in $savedData
                        $results = array_map(function ($id) use ($results) {
                            return array_values(
                                array_filter($results, function ($result) use ($id) {
                                    return $result->ID == $id;
                                }),
                            )[0];
                        }, $savedData[$postType]);
                    }
                }
                break;
            default:
                // Used to display generic data in the Gutenberg editor, unrelated to cookies
                $results = $qb->get();
                break;
        }

        return $results;
    }

    private static function getSavedData(bool $handleCurrent = true, ?string $postType = null): array
    {
        $data = [];

        if (isset($_COOKIE[self::COOKIE_NAME])) {
            $decoded = json_decode(stripslashes($_COOKIE[self::COOKIE_NAME]), true);
            $data = is_array($decoded) ? $decoded : [];
        }

        if ($handleCurrent && null !== $postType) {
            if (isset($data[$postType])) {
                $maxToReturn = self::getPostTypesToMonitor()[$postType][self::KEY_TO_KEEP] ?? 3;

                $currentId = get_the_ID();

                if (in_array($currentId, $data[$postType])) {
                    $index = array_search($currentId, $data[$postType]);
                    unset($data[$postType][$index]);
                }

                // Return only the first X elements
                $data[$postType] = array_slice($data[$postType], 0, $maxToReturn);
            }
        }

        return $data;
    }

    public static function saveLastSeen($content)
    {
        if (is_admin() || wp_doing_ajax() || wp_is_json_request() || !is_singular() || is_feed()) {
            return $content;
        }

        $currentPostType = get_post_type();

        $toMonitor = self::getPostTypesToMonitor();

        $savedData = self::getSavedData(handleCurrent: false);

        if (in_array($currentPostType, array_keys($toMonitor))) {
            $currentId = get_the_ID();

            $toMonitorData = $toMonitor[$currentPostType];

            if (isset($toMonitorData[self::KEY_TO_KEEP]) && $toMonitorData[self::KEY_TO_KEEP] > 0) {
                $toKeep = $toMonitorData[self::KEY_TO_KEEP];
                $toKeepIncludingFallbackForCurrentPost = $toKeep + 1;

                if (!isset($savedData[$currentPostType])) {
                    $savedData[$currentPostType] = [];
                }

                if (in_array($currentId, $savedData[$currentPostType])) {
                    $index = array_search($currentId, $savedData[$currentPostType]);

                    // Remove current element
                    unset($savedData[$currentPostType][$index]);

                    // Add current element
                    array_unshift($savedData[$currentPostType], $currentId);
                } else {
                    if (count($savedData[$currentPostType]) >= $toKeepIncludingFallbackForCurrentPost) {
                        // Remove last element
                        array_pop($savedData[$currentPostType]);
                    }

                    // Add current element
                    array_unshift($savedData[$currentPostType], $currentId);
                }

                // Remove extra elements
                $savedData[$currentPostType] = array_slice($savedData[$currentPostType], 0, $toKeepIncludingFallbackForCurrentPost);
            }
        }

        setcookie(self::COOKIE_NAME, json_encode($savedData), [
            'expires' => time() + self::COOKIE_DURATION,
            'path' => '/',
            'secure' => is_ssl(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        return $content;
    }
}
