import Parser from './application/components/parser';

export default class {
    private parser: Parser;
    private definitions: any[] = [];

    public constructor () {
        this.parser = new Parser();
    }

    public registerComponent (selector: string, component: any) {
        this.definitions.push({selector, component});
    }

    public run () {
        window.document.addEventListener('DOMContentLoaded', () => this.parse(window.document.documentElement));
    }

    public parse (context?: string|Element|DocumentFragment): void {
        const element = (typeof context === 'string') ? window.document.querySelector(context) : context;

        if (element) {
            const components = this.parser.parse(this.definitions, element);

            components.forEach((component) => {
                component.injectApplication(this);
                component.run();
            });
        }
    }
}
