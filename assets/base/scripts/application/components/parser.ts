import 'core-js/modules/es6.array.from';

export default class {
    public parse (definitions: Array<{}>, element: Element|DocumentFragment) {
        const instances: any[] = [];

        definitions.forEach((definition: any) => {
            if (element) {
                const elements = element.querySelectorAll(definition.selector);
                Array.from(elements).forEach((element: Element) => instances.push(new definition.component(element)));
            }
        });

        return instances;
    }
}
