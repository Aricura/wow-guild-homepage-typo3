import Component from '../../../base/scripts/application/components/component';

export default class extends Component {
    public static readonly selector: string = '.js-scroll-to';
    protected name: string = 'scroll-to';
    private target: HTMLElement;

    public run (): void {
        this.setup();
        this.bind();
    }

    private setup (): void {
        const element = this.element as HTMLAnchorElement;
        const href = element.href.split('#');
        if (href.length > 1) {
            this.target = document.getElementById(href[1]) as HTMLElement;
        }
    }

    private bind (): void {
        this.element.addEventListener('click', this.onAnchorClicked.bind(this));
    }

    private onAnchorClicked (event: MouseEvent): void {
        if (this.target) {
            event.preventDefault();

            window.scroll({
                top: this.target.offsetTop - 90,
                left: 0,
                behavior: 'smooth'
            });
        }
    }
}
