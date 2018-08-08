// Base
import './base/scripts/common/features';
import './base/scripts/common/state';
import Application from './base/scripts/application';

// Components
import ContentWheel from './components/content-wheel';
import ScrollTo from './components/scroll-to';
import Slider from './components/slider';

 // Register all components
const application = new Application();
application.registerComponent(ContentWheel.selector, ContentWheel);
application.registerComponent(ScrollTo.selector, ScrollTo);
application.registerComponent(Slider.selector, Slider);
application.run();
