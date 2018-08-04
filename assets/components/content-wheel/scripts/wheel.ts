import Component from '../../../base/scripts/application/components/component';

export default class extends Component {
    public static readonly selector: string = '.js-wheel';
    protected name: string = 'wheel';
    private panels: NodeListOf<HTMLElement>;

    public run (): void {
        this.setup();
        this.bind();
    }

    private setup (): void {
        this.panels = this.element.querySelectorAll('.js-wheel-panel') as NodeListOf<HTMLElement>;
    }

    private bind (): void {
        if (this.panels && this.panels.length > 0) {
            for(let index = 0; index < this.panels.length; index++) {
                const panelHeader = this.panels[index].querySelector('.panel-header') as HTMLElement;
                panelHeader.addEventListener('click', this.onPanelHeaderClicked.bind(this));
            }
        }
    }

    private onPanelHeaderClicked (event: MouseEvent): void {
        const element = event.target as HTMLElement;
        const panel = element.closest('.js-wheel-panel') as HTMLElement;

        if (panel.classList.contains('active')) {
            panel.classList.remove('active');
            return;
        }

        for(let index = 0; index < this.panels.length; index++) {
            this.panels[index].classList.remove('active');
        }

        panel.classList.add('active');

        window.scroll({
            top: panel.offsetTop - 15,
            left: 0,
            behavior: 'smooth'
        });
    }
}
