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

// Register product page component
Alpine.data('productPage', () => ({
    showSuccessMessage: false,
    isSubmitting: false,
    selectedVariant: null,
    selectedPrice: null,
    variants: {},
    isBundle: false,
    bundleSizes: {},

    init() {
        const el = this.$el;
        
        // Check if this is a bundle product
        this.isBundle = el.dataset.isBundle === 'true';
        
        if (this.isBundle) {
            // Initialize bundle sizes object
            const bundleItems = JSON.parse(el.dataset.bundleItems || '[]');
            bundleItems.forEach(item => {
                this.bundleSizes[item.name] = '';
            });
            
            // Set price for bundles
            const priceData = el.dataset.price;
            if (priceData && priceData.includes('$')) {
                const numericPrice = parseFloat(priceData.replace(/[^0-9.]/g, '')) * 100;
                this.selectedPrice = numericPrice;
            } else if (priceData) {
                this.selectedPrice = parseInt(priceData);
            }
        } else {
            // Check if we have variant data
            const firstVariant = el.dataset.firstVariant;
            const firstPrice = el.dataset.firstPrice;
            
            if (firstVariant) {
                // Has variants - set initial values
                this.selectedVariant = firstVariant;
                // Extract numeric part from price string like "NZ$39.99" -> 3999
                const priceStr = firstPrice;
                if (priceStr && priceStr.includes('$')) {
                    const numericPrice = parseFloat(priceStr.replace(/[^0-9.]/g, '')) * 100;
                    this.selectedPrice = numericPrice;
                } else if (priceStr) {
                    this.selectedPrice = parseInt(priceStr);
                }
            } else {
                // No variants, get single price
                const priceData = el.dataset.price;
                if (priceData && priceData.includes('$')) {
                    const numericPrice = parseFloat(priceData.replace(/[^0-9.]/g, '')) * 100;
                    this.selectedPrice = numericPrice;
                } else if (priceData) {
                    this.selectedPrice = parseInt(priceData);
                }
            }
        }
        
    },

    updatePrice(price) {
        this.selectedPrice = price;
    },

    updatePriceFromString(priceStr) {
        if (priceStr && priceStr.includes('$')) {
            const numericPrice = parseFloat(priceStr.replace(/[^0-9.]/g, '')) * 100;
            this.selectedPrice = numericPrice;
        } else if (priceStr) {
            this.selectedPrice = parseInt(priceStr);
        }
        console.log('Price updated to:', this.selectedPrice);
    },

    getSelectedSku() {
        return this.variants[this.selectedVariant]?.sku || '';
    },
    
    canAddToCart() {
        if (this.isBundle) {
            // Check if all bundle items have sizes selected
            return Object.values(this.bundleSizes).every(size => size !== '');
        }
        return true;
    },
    
    getBundleConfiguration() {
        if (!this.isBundle) return '';
        return JSON.stringify(this.bundleSizes);
    },
    
    getBundleConfigText() {
        if (!this.isBundle) return '';
        return Object.entries(this.bundleSizes)
            .map(([item, size]) => `${item}: ${size}`)
            .join(', ');
    },

    handleAddToCart(event) {
        event.preventDefault();
        
        if (this.isBundle && !this.canAddToCart()) {
            alert('Please select a size for each item in the bundle');
            return false;
        }
        
        // Store bundle configuration in localStorage for checkout
        if (this.isBundle) {
            const bundleConfig = {
                productTitle: document.querySelector('h1')?.textContent?.trim() || 'Bundle',
                items: this.bundleSizes,
                timestamp: Date.now()
            };
            
            // Get existing configs or create new array
            let configs = JSON.parse(localStorage.getItem('bundleConfigurations') || '[]');
            configs.push(bundleConfig);
            
            // Keep only last 10 configs
            if (configs.length > 10) {
                configs = configs.slice(-10);
            }
            
            localStorage.setItem('bundleConfigurations', JSON.stringify(configs));
        }
        
        this.isSubmitting = true;
        
        // Submit the form manually after saving to localStorage
        const form = event.target;
        setTimeout(() => {
            form.submit();
        }, 100);
        
        return false;
    }
}));

Livewire.start();
