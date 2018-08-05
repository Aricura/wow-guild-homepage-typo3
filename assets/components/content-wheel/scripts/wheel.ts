import Component from '../../../base/scripts/application/components/component';

export default class extends Component {
    public static readonly selector: string = '.js-wheel';
    protected name: string = 'wheel';
    private container: HTMLElement;
    private panels: NodeListOf<HTMLElement>;
    private items: NodeListOf<HTMLElement>;
    private buttonPrevious: HTMLElement;
    private buttonNext: HTMLElement;
    private numberOfSlides: number = 0;
    private currentIndex: number = 0;

    public run (): void {
        this.setup();
        this.bind();
    }

    private setup (): void {
        this.container = this.element.querySelector('.js-wheel-container') as HTMLElement;
        this.panels = this.element.querySelectorAll('.js-wheel-panel') as NodeListOf<HTMLElement>;
        this.items = this.element.querySelectorAll('.js-wheel-item') as NodeListOf<HTMLElement>;
        this.buttonPrevious = this.element.querySelector('.js-wheel-prev') as HTMLInputElement;
        this.buttonNext = this.element.querySelector('.js-wheel-next') as HTMLInputElement;

        this.numberOfSlides = this.items.length;
        this.moveToIndex(0);
    }

    private bind (): void {
        if (this.items && this.items.length > 0) {
            for(let index = 0; index < this.items.length; index++) {
                this.items[index].addEventListener('click', this.onWheelItemClicked.bind(this));
            }
        }

        if (this.panels && this.panels.length > 0) {
            for(let index = 0; index < this.panels.length; index++) {
                const panelHeader = this.panels[index].querySelector('.panel-header') as HTMLElement;
                panelHeader.addEventListener('click', this.onPanelHeaderClicked.bind(this));
            }
        }

        if (this.buttonPrevious) {
            this.buttonPrevious.addEventListener('click', this.onControlPreviousClicked.bind(this));
        }

        if (this.buttonNext) {
            this.buttonNext.addEventListener('click', this.onControlNextClicked.bind(this));
        }
    }

    private moveToIndex (position: number): void {
        const containerStyling = window.getComputedStyle(this.container);
        if ('none' === containerStyling.display) {
            return;
        }

        // check if the new slider index doesn't exceed the bounds
        if (position >= this.numberOfSlides) {
            position = 0;
        } else if (position < 0) {
            position = this.numberOfSlides - 1;
        }

        // store the nex index
        this.currentIndex = position;

        for(let index = 0; index < this.items.length; index++) {
            this.items[index].classList.remove('active');
        }

        const panelContainer = this.panels[0].parentElement as HTMLElement;
        const transform = -100 * this.currentIndex;
        panelContainer.style.transform = 'translateX(' + transform + '%)';

        this.items[this.currentIndex].classList.add('active');
    }

    private onControlPreviousClicked (): void {
        this.moveToIndex(this.currentIndex - 1);
    }

    private onControlNextClicked (): void {
        this.moveToIndex(this.currentIndex + 1);
    }

    private onWheelItemClicked (event: MouseEvent): void {
        const element = event.target as HTMLElement;
        let index = parseInt(element.dataset.index!);

        if (!element.classList.contains('js-wheel-item')) {
            const parent = element.closest('.js-wheel-item') as HTMLElement;
            index = parseInt(parent.dataset.index!);
        }

        this.moveToIndex(index);
    }

    private onPanelHeaderClicked (event: MouseEvent): void {
        const containerStyling = window.getComputedStyle(this.container);
        if ('none' !== containerStyling.display) {
            return;
        }

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
