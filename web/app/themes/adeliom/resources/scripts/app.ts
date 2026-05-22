import '@scripts/navigations/menu';
import '@scripts/structure/modal';
import '@scripts/structure/lightbox';
import '@scripts/layouts/page';

import Notifications from './components/notifications';
import CopyLink from './components/copy-link';
import { initCustomSelect } from './components/select';

Notifications.init();
CopyLink.init();
initCustomSelect();
