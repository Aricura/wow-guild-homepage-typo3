import Application from '../../application';

export default class {
    protected name: string;
    protected element: HTMLElement;
    protected app: Application;
    protected options: {} = {};

    public constructor (element: HTMLElement, options: {} = {}) {
        this.element = element;
        this.options = options;
    }

    public injectApplication (app: Application): void {
        this.app = app;
    }

    protected dispatch (name: string, detail?: any, bubbles: boolean = true): void {
        const event = document.createEvent('CustomEvent');

        event.initCustomEvent(`${this.name}.${name}`, bubbles, false, {
            ...detail,
            component: this,
        });

        this.element.dispatchEvent(event);
    }

    protected on (name: string, listener: EventListener): void {
        this.element.addEventListener(`${this.name}.${name}`, listener);
    }

    protected off (name: string, listener: EventListener): void {
        this.element.removeEventListener(`${this.name}:${name}`, listener);
    }
}
