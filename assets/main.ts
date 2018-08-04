// Base
import './base/scripts/common/features';
import './base/scripts/common/state';
import Application from './base/scripts/application';

// Components
 import Slider from './components/slider';

 // Register all components
const application = new Application();
application.registerComponent(Slider.selector, Slider);
application.run();
