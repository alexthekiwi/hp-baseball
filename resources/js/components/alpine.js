import collapse from '@alpinejs/collapse';
import focus from '@alpinejs/focus'
import intersect from "@alpinejs/intersect";
import { Livewire, Alpine } from '../../../vendor/livewire/livewire/dist/livewire.esm';

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.plugin(focus);
Alpine.plugin(intersect);

// Register header component
Alpine.data('header', () => ({
    isScrolled: false,
    searchOpen: false,
    navigationMenuOpen: false,

    init() {
        this.checkScrollState();
        this.updateHeaderState();

        window.addEventListener('scroll', () => {
            this.checkScrollState();
            this.updateHeaderState();
        });

        this.$watch('navigationMenuOpen', () => this.updateHeaderState());
        this.$watch('searchOpen', () => this.updateHeaderState());
    },

    checkScrollState() {
        this.isScrolled = window.scrollY > 80;
    },

    updateHeaderState() {
        const shouldAddScrolledClass = this.isScrolled || this.navigationMenuOpen || this.searchOpen;

        if (shouldAddScrolledClass) {
            this.$el.classList.add('scrolled');
        } else {
            this.$el.classList.remove('scrolled');
        }
    },

    navigationMenuToggle() {
        this.navigationMenuOpen = !this.navigationMenuOpen;
    },

    navigationMenuClose() {
        this.navigationMenuOpen = false;
    },

    handleClickAway() {
        if (this.searchOpen) {
            this.searchOpen = false;
        }
    }
}));

Livewire.start();
