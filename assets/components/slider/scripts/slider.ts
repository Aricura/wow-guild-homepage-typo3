import Component from '../../../base/scripts/application/components/component';

export default class extends Component {
    public static readonly selector: string = '.js-slider';
    protected name: string = 'slider';
    private sliderContainer: HTMLElement;
    private buttonPrevious: HTMLElement;
    private buttonNext: HTMLElement;
    private overlayContainer: HTMLElement;
    private numberOfSlides: number = 0;
    private currentIndex: number = 0;
    private swipePositionX = 0;

    public run (): void {
        this.setup();
        this.bind();
    }

    private setup (): void {
        this.sliderContainer = this.element.querySelector('.js-slider-slides') as HTMLInputElement;
        this.buttonPrevious = this.element.querySelector('.js-slider-prev') as HTMLInputElement;
        this.buttonNext = this.element.querySelector('.js-slider-next') as HTMLInputElement;
        this.overlayContainer = this.element.querySelector('.js-slider-overlay-container') as HTMLInputElement;

        this.numberOfSlides = this.sliderContainer.children.length;
        this.moveToIndex(this.currentIndex);
    }

    private bind (): void {
        this.element.addEventListener('touchstart', this.onTouchStart.bind(this));
        this.element.addEventListener('touchend', this.onTouchEnd.bind(this));

        if (this.buttonPrevious) {
            this.buttonPrevious.addEventListener('click', this.onControlPreviousClicked.bind(this));
        }

        if (this.buttonNext) {
            this.buttonNext.addEventListener('click', this.onControlNextClicked.bind(this));
        }
    }

    /**
     * On touch start event to store the current X position of the touch surface.
     *
     * @param {TouchEvent} event
     */
    private onTouchStart (event: TouchEvent): void {
        this.swipePositionX = event.changedTouches[0].pageX;
    }

    /**
     * On touch end event to detect the swipe distance and trigger an action.
     *
     * @param {TouchEvent} event
     */
    private onTouchEnd (event: TouchEvent): void {
        const swipeDistanceX = event.changedTouches[0].pageX - this.swipePositionX;
        const swipeThreshold = 50;

        if (swipeDistanceX < -swipeThreshold) {
            this.moveToIndex(this.currentIndex + 1);
        } else if (swipeDistanceX > swipeThreshold) {
            this.moveToIndex(this.currentIndex - 1);
        }
    }

    /**
     * The previous control button is clicked.
     */
    private onControlPreviousClicked (): void {
        this.moveToIndex(this.currentIndex - 1);
    }

    /**
     * The next control button is clicked.
     */
    private onControlNextClicked (): void {
        this.moveToIndex(this.currentIndex + 1);
    }

    /**
     * Move the slider to the specified index.
     *
     * @param {number} sliderIndex
     */
    private moveToIndex (sliderIndex: number): void {
        // check if the new slider index doesn't exceed the bounds
        if (sliderIndex >= this.numberOfSlides) {
            sliderIndex = 0;
        } else if (sliderIndex < 0) {
            sliderIndex = this.numberOfSlides - 1;
        }

        // store the nex index
        this.currentIndex = sliderIndex;

        // get the width of a single slider item required for the CSS transformation
        const firstSliderItem = this.sliderContainer.children[0] as HTMLElement;
        const firstSliderItemStyling = window.getComputedStyle(firstSliderItem);
        const firstSliderItemWidth = firstSliderItem.offsetWidth
            + parseInt(firstSliderItemStyling.marginLeft!, 0)
            + parseInt(firstSliderItemStyling.marginRight!, 0);
        const sliderItemWidthPercentage = (100.0 * firstSliderItemWidth / this.sliderContainer.offsetWidth).toFixed(0);

        // slider animation is done using CSS transform-X
        const transform = -sliderItemWidthPercentage * sliderIndex;
        this.sliderContainer.style.transform = 'translateX(' + transform + '%)';

        // update the overlay content using the template defined by the new slider (if there is an overlay)
        if (this.overlayContainer) {
            const currentSlide = this.sliderContainer.children[this.currentIndex] as HTMLElement;
            const templateId = currentSlide ? currentSlide.dataset.overlay! : '';

            if (templateId) {
                const templateElement = document.getElementById(templateId) as HTMLInputElement;
                if (templateElement) {
                    // animate the overlay content fade out (old content) and fade in (new content
                    this.overlayContainer.classList.add('in-progress');

                    let container = this.overlayContainer;
                    window.setTimeout(function() {
                        container.innerHTML = templateElement.innerHTML;
                        container.classList.remove('in-progress');
                    }, 500);
                }
            }
        }
    }
}
