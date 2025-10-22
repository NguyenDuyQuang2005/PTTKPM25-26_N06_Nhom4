(function() {
    'use strict';

    // ========================================
    // CONFIGURATION & CONSTANTS
    // ========================================
    const CONFIG = {
        STORAGE_KEYS: {
            CHECKOUT_INFO: 'minhlong_checkout_info',
            FILTER_STATE: 'minhlong_products_filter',
            SEARCH_QUERY: 'minhlong_search_query',
            FAVORITES: 'minhlong_favorites'
        },
        CURRENCY: '₫',
        LOCALE: 'vi-VN',
        ANIMATION_DURATION: 300
    };

    // ========================================
    // UTILITY FUNCTIONS
    // ========================================
    const Utils = {
        // Format currency
        formatCurrency(amount, currency = CONFIG.CURRENCY) {
            return new Intl.NumberFormat(CONFIG.LOCALE).format(amount) + currency;
        },

        // Debounce function
        debounce(func, wait, immediate) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    timeout = null;
                    if (!immediate) func(...args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func(...args);
            };
        },

        // Throttle function
        throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        },

        // Query selector with error handling
        $(selector, context = document) {
            try {
                return context.querySelector(selector);
            } catch (error) {
                console.error('Error querying selector:', selector, error);
                return null;
            }
        },

        // Query selector all with error handling
        $$(selector, context = document) {
            try {
                return context.querySelectorAll(selector);
            } catch (error) {
                console.error('Error querying selector:', selector, error);
                return [];
            }
        },

        // Add event listener with error handling
        addEvent(element, event, handler, options = {}) {
            if (element && typeof handler === 'function') {
                element.addEventListener(event, handler, options);
            }
        }
    };

    // ========================================
    // STORAGE MANAGER
    // ========================================
    const Storage = {
        set(key, value) {
            try {
                localStorage.setItem(key, JSON.stringify(value));
                return true;
            } catch (error) {
                console.error('Error saving to localStorage:', error);
                return false;
            }
        },
        
        get(key, defaultValue = null) {
            try {
                const item = localStorage.getItem(key);
                return item ? JSON.parse(item) : defaultValue;
            } catch (error) {
                console.error('Error reading from localStorage:', error);
                return defaultValue;
            }
        }
    };

    // ========================================
    // NOTIFICATION MANAGER
    // ========================================
    class NotificationManager {
        constructor() {
            this.notifications = [];
            this.container = null;
            this.init();
        }

        init() {
            this.createContainer();
        }

        createContainer() {
            this.container = document.createElement('div');
            this.container.className = 'notification-container';
            this.container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                display: flex;
                flex-direction: column;
                gap: 10px;
                max-width: 400px;
            `;
            document.body.appendChild(this.container);
        }

        show(message, type = 'info', duration = 4000) {
            const id = Math.random().toString(36).substr(2, 9);
            const notification = this.createNotification(id, message, type);
            
            this.notifications.push({ id, notification });
            this.container.appendChild(notification);
            
            // Auto remove
            setTimeout(() => {
                this.remove(id);
            }, duration);
            
            return id;
        }

        createNotification(id, message, type) {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.dataset.id = id;
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            const colors = {
                success: '#27ae60',
                error: '#e74c3c',
                warning: '#f39c12',
                info: '#3498db'
            };
            
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="fas ${icons[type] || icons.info}"></i>
                    <span>${message}</span>
                    <button class="notification-close" onclick="window.notificationManager.remove('${id}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            notification.style.cssText = `
                background: ${colors[type] || colors.info};
                color: white;
                padding: 15px 20px;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                animation: slideInRight 0.3s ease-out;
                position: relative;
            `;
            
            return notification;
        }

        remove(id) {
            const index = this.notifications.findIndex(n => n.id === id);
            if (index !== -1) {
                const { notification } = this.notifications[index];
                notification.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
                this.notifications.splice(index, 1);
            }
        }
    }

    // ========================================
    // MENU SYNC MANAGER
    // ========================================
    class MenuSyncManager {
        constructor() {
            this.currentPage = this.getCurrentPage();
            this.init();
        }

        init() {
            this.updateActiveMenuItems();
            this.bindMenuEvents();
        }

        getCurrentPage() {
            const path = window.location.pathname;
            const filename = path.split('/').pop() || 'index.html';
            
            const pageMap = {
                '': 'home',
                'welcome': 'home',
                'product': 'product',
                'cart': 'cart',
                'checkout': 'checkout',
                'login': 'login',
                'register': 'register'
            };
            
            return pageMap[filename] || 'home';
        }

        updateActiveMenuItems() {
            // Remove active class from all menu items
            const menuItems = Utils.$$('.menu > ul > li > a');
            menuItems.forEach(item => {
                item.classList.remove('active');
            });

            // Add active class based on current page
            const activeSelectors = {
                'home': 'a[href="/"], a[href="/welcome"]',
                'product': 'a[href*="product"]',
                'cart': 'a[href="/cart"]',
                'checkout': 'a[href="/checkout"]',
                'login': 'a[href*="login"]',
                'register': 'a[href*="register"]'
            };

            const selector = activeSelectors[this.currentPage];
            if (selector) {
                const activeItems = Utils.$$(selector);
                activeItems.forEach(item => {
                    item.classList.add('active');
                });
            }
        }

        bindMenuEvents() {
            // Handle mobile menu toggle
            const mobileToggle = Utils.$('#mobileMenuToggle');
            const menu = Utils.$('#menu');
            
            if (mobileToggle && menu) {
                mobileToggle.addEventListener('click', () => {
                    this.toggleMobileMenu();
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', (e) => {
                    if (!mobileToggle.contains(e.target) && !menu.contains(e.target)) {
                        this.closeMobileMenu();
                    }
                });
            }

            // Handle search functionality
            this.initializeSearch();
        }

        toggleMobileMenu() {
            const mobileToggle = Utils.$('#mobileMenuToggle');
            const menu = Utils.$('#menu');
            
            if (mobileToggle && menu) {
                mobileToggle.classList.toggle('active');
                menu.classList.toggle('active');
            }
        }

        closeMobileMenu() {
            const mobileToggle = Utils.$('#mobileMenuToggle');
            const menu = Utils.$('#menu');
            
            if (mobileToggle && menu) {
                mobileToggle.classList.remove('active');
                menu.classList.remove('active');
            }
        }

        initializeSearch() {
            const searchInput = Utils.$('.others input[placeholder*="Tìm kiếm"]');
            const searchIcon = Utils.$('.others .fa-search');
            
            if (searchInput && searchIcon) {
                // Create search suggestions container
                const searchContainer = searchInput.parentElement;
                let suggestionsContainer = searchContainer.querySelector('.search-suggestions');
                
                if (!suggestionsContainer) {
                    suggestionsContainer = document.createElement('div');
                    suggestionsContainer.className = 'search-suggestions';
                    searchContainer.appendChild(suggestionsContainer);
                }

                // Sample search suggestions
                const suggestions = [
                    'Sách văn học',
                    'Sách kinh tế',
                    'Sách thiếu nhi',
                    'Sách phát triển bản thân',
                    'Sách chuyên ngành',
                    'Truyện tranh',
                    'Tiểu thuyết',
                    'Sách khoa học',
                    'Sách marketing',
                    'Sách tâm lý'
                ];

                // Search input event
                searchInput.addEventListener('input', Utils.debounce((e) => {
                    const query = e.target.value.toLowerCase().trim();
                    
                    if (query.length > 0) {
                        const filteredSuggestions = suggestions.filter(item => 
                            item.toLowerCase().includes(query)
                        );
                        
                        if (filteredSuggestions.length > 0) {
                            suggestionsContainer.innerHTML = '';
                            filteredSuggestions.slice(0, 5).forEach(suggestion => {
                                const item = document.createElement('div');
                                item.className = 'search-suggestion-item';
                                item.textContent = suggestion;
                                item.addEventListener('click', () => {
                                    searchInput.value = suggestion;
                                    suggestionsContainer.classList.remove('show');
                                    this.performSearch(suggestion);
                                });
                                suggestionsContainer.appendChild(item);
                            });
                            suggestionsContainer.classList.add('show');
                        } else {
                            suggestionsContainer.classList.remove('show');
                        }
                    } else {
                        suggestionsContainer.classList.remove('show');
                    }
                }, 300));

                // Hide suggestions when clicking outside
                document.addEventListener('click', (e) => {
                    if (!searchContainer.contains(e.target)) {
                        suggestionsContainer.classList.remove('show');
                    }
                });

                // Search icon click
                searchIcon.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (searchInput.value.trim()) {
                        this.performSearch(searchInput.value.trim());
                    }
                });

                // Enter key search
                searchInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter' && searchInput.value.trim()) {
                        e.preventDefault();
                        this.performSearch(searchInput.value.trim());
                        suggestionsContainer.classList.remove('show');
                    }
                });
            }
        }

        performSearch(query) {
            // Store search query for use on products page
            Storage.set(CONFIG.STORAGE_KEYS.SEARCH_QUERY, query);
            
            // Redirect to products page with search
            window.location.href = `/products?search=${encodeURIComponent(query)}`;
        }
    }

    // ========================================
    // SLIDER MANAGER
    // ========================================
    class SliderManager {
        constructor() {
            this.init();
        }

        init() {
            this.initializeSlider();
            this.initializeStickyHeader();
        }

        initializeSlider() {
            const imgPosition = Utils.$$('.aspect-ratio-169 img');
            const imgContainer = Utils.$('.aspect-ratio-169');
            const dotItem = Utils.$$('.dot');
            
            if (imgPosition.length > 0 && imgContainer && dotItem.length > 0) {
                let index = 0;
                let imgNumber = imgPosition.length;

                // Create wrapper for images
                const sliderWrapper = document.createElement('div');
                sliderWrapper.style.cssText = `
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: ${imgNumber * 100}%;
                    height: 100%;
                    display: flex;
                    transition: transform 0.3s ease;
                `;
                
                // Move all images into wrapper
                imgPosition.forEach(function(image, i) {
                    image.style.cssText = `
                        width: ${100/imgNumber}%;
                        height: 100%;
                        object-fit: cover;
                        flex-shrink: 0;
                    `;
                    sliderWrapper.appendChild(image);
                });
                
                imgContainer.appendChild(sliderWrapper);

                // Add event listeners for dots
                dotItem.forEach(function(dot, i) {
                    dot.addEventListener('click', function(){
                        this.slider(i);
                    }.bind(this));
                }.bind(this));

                // Auto slide function
                const imgSlide = () => {
                    index++;
                    if (index >= imgNumber) {
                        index = 0;
                    }
                    this.slider(index);
                };

                // Display image by index
                this.slider = (newIndex) => {
                    index = newIndex;
                    sliderWrapper.style.transform = "translateX(-" + index * (100/imgNumber) + "%)";
                    
                    // Update active dot
                    dotItem.forEach(function(dot, i) {
                        dot.classList.toggle("active", i === index);
                    });
                };

                // Start auto slide
                setInterval(imgSlide, 3000);
            }
        }

        initializeStickyHeader() {
            const header = Utils.$('header');
            if (header) {
                window.addEventListener('scroll', Utils.throttle(function() {
                    let x = window.pageYOffset;
                    if (x > 0) {
                        header.classList.add('sticky');
                    } else {
                        header.classList.remove('sticky');
                    }
                }, 100));
            }
        }
    }

    // ========================================
    // PRODUCT PAGE MANAGER
    // ========================================
    class ProductPageManager {
        constructor() {
            this.init();
        }

        init() {
            this.initializeTabs();
            this.initializeImageGallery();
            this.initializeQuantityControls();
            this.initializeReviews();
        }

        initializeTabs() {
            const tabButtons = Utils.$$('.tab-button');
            const tabContents = Utils.$$('.tab-content');

            if (!tabButtons.length || !tabContents.length) return;

            tabButtons.forEach(button => {
                button.addEventListener('click', e => {
                    e.preventDefault();
                    const target = button.dataset.tab;

                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    button.classList.add('active');
                    const targetElement = Utils.$('#' + target);
                    if (targetElement) targetElement.classList.add('active');
                });
            });
        }

        initializeImageGallery() {
            const bigImage = Utils.$('.product-content-left-big-img img');
            const thumbnails = Utils.$$('.product-content-left-small-img img');

            if (!bigImage || !thumbnails.length) return;

            thumbnails.forEach(img => {
                img.addEventListener('click', () => {
                    thumbnails.forEach(i => i.classList.remove('active'));
                    img.classList.add('active');

                    bigImage.classList.add('fade-out');
                    setTimeout(() => {
                        bigImage.src = img.src;
                        bigImage.alt = img.alt;
                        bigImage.classList.remove('fade-out');
                        bigImage.classList.add('fade-in');
                    }, 150);
                });

                img.addEventListener('mouseenter', () => (img.style.transform = "scale(1.1)"));
                img.addEventListener('mouseleave', () => {
                    if (!img.classList.contains("active")) img.style.transform = "scale(1)";
                });
            });

            if (thumbnails[0]) thumbnails[0].classList.add('active');
        }

        initializeQuantityControls() {
            const minusBtn = Utils.$('.quantity-decrease');
            const plusBtn = Utils.$('.quantity-increase');
            const input = Utils.$('#quantity');
            if (!input) return;

            if (minusBtn) {
                minusBtn.addEventListener('click', () => {
                    input.value = Math.max(1, parseInt(input.value) - 1);
                });
            }

            if (plusBtn) {
                plusBtn.addEventListener('click', () => {
                    input.value = parseInt(input.value) + 1;
                });
            }
        }

        initializeReviews() {
            const starRating = Utils.$('#starRating');
            const reviewForm = Utils.$('#reviewForm');
            
            if (starRating) {
                this.initializeStarRating();
            }
            
            if (reviewForm) {
                this.initializeReviewForm();
            }
        }

        initializeStarRating() {
            const starRating = Utils.$('#starRating');
            const stars = Utils.$$('#starRating i');
            const ratingText = Utils.$('#starRating .rating-text');
            let currentRating = 0;
            
            const ratingTexts = {
                1: 'Rất tệ',
                2: 'Tệ',
                3: 'Bình thường',
                4: 'Tốt',
                5: 'Rất tốt'
            };
            
            stars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    currentRating = index + 1;
                    this.updateStarDisplay(stars, currentRating, ratingText, ratingTexts);
                }.bind(this));
                
                star.addEventListener('mouseenter', function() {
                    this.updateStarDisplay(stars, index + 1, ratingText, ratingTexts);
                }.bind(this));
            });
            
            starRating.addEventListener('mouseleave', function() {
                this.updateStarDisplay(stars, currentRating, ratingText, ratingTexts);
            }.bind(this));
        }

        updateStarDisplay(stars, rating, ratingText, ratingTexts) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('far');
                    star.classList.add('fas', 'filled');
                } else {
                    star.classList.remove('fas', 'filled');
                    star.classList.add('far');
                }
            });
            
            if (ratingText) {
                ratingText.textContent = ratingTexts[rating] || 'Chọn đánh giá';
            }
        }

        initializeReviewForm() {
            const reviewForm = Utils.$('#reviewForm');
            
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(reviewForm);
                const reviewData = {
                    name: formData.get('reviewerName'),
                    email: formData.get('reviewerEmail'),
                    title: formData.get('reviewTitle'),
                    content: formData.get('reviewContent'),
                    tags: formData.get('reviewTags'),
                    rating: this.getCurrentRating()
                };
                
                if (reviewData.rating === 0) {
                    window.notificationManager?.show('Vui lòng chọn đánh giá sao!', 'error');
                    return;
                }
                
                // Simulate form submission
                this.submitReview(reviewData);
            }.bind(this));
        }

        getCurrentRating() {
            const stars = Utils.$$('#starRating i.filled');
            return stars.length;
        }

        submitReview(reviewData) {
            // Show loading state
            const submitBtn = Utils.$('.btn-submit-review');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Đang gửi...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                // Add review to the list
                this.addReviewToList(reviewData);
                
                // Reset form
                Utils.$('#reviewForm').reset();
                this.resetStarRating();
                
                // Reset button
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                
                // Show success message
                window.notificationManager?.show('Cảm ơn bạn đã đánh giá! Đánh giá của bạn đã được gửi thành công.', 'success');
                
                // Scroll to reviews
                const reviewsList = Utils.$('.reviews-list');
                if (reviewsList) {
                    reviewsList.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 1500);
        }

        addReviewToList(reviewData) {
            const reviewsList = Utils.$('.reviews-list');
            if (!reviewsList) return;
            
            const reviewItem = document.createElement('div');
            reviewItem.className = 'review-item';
            
            const tags = reviewData.tags ? reviewData.tags.split(',').map(tag => tag.trim()) : [];
            const tagsHtml = tags.map(tag => `<span class="tag">${tag}</span>`).join('');
            
            const starsHtml = Array.from({length: 5}, (_, i) => 
                `<i class="fas fa-star${i < reviewData.rating ? '' : ' far'}"></i>`
            ).join('');
            
            reviewItem.innerHTML = `
                <div class="reviewer-info">
                    <img src="/frontend/asset/images/User.png" alt="${reviewData.name}">
                    <div class="reviewer-details">
                        <h4>${reviewData.name}</h4>
                        <div class="review-rating">
                            ${starsHtml}
                        </div>
                        <span class="review-date">${new Date().toLocaleDateString('vi-VN')}</span>
                    </div>
                </div>
                <div class="review-content">
                    <h5>${reviewData.title}</h5>
                    <p>${reviewData.content}</p>
                    ${tagsHtml ? `<div class="review-tags">${tagsHtml}</div>` : ''}
                </div>
            `;
            
            // Add animation
            reviewItem.style.opacity = '0';
            reviewItem.style.transform = 'translateY(20px)';
            reviewsList.insertBefore(reviewItem, reviewsList.firstChild);
            
            // Animate in
            setTimeout(() => {
                reviewItem.style.transition = 'all 0.5s ease';
                reviewItem.style.opacity = '1';
                reviewItem.style.transform = 'translateY(0)';
            }, 100);
        }

        resetStarRating() {
            const stars = Utils.$$('#starRating i');
            const ratingText = Utils.$('.rating-text');
            
            stars.forEach(star => {
                star.classList.remove('fas', 'filled');
                star.classList.add('far');
            });
            
            if (ratingText) {
                ratingText.textContent = 'Chọn đánh giá';
            }
        }
    }

    // ========================================
    // CHECKOUT PAGE MANAGER
    // ========================================
    class CheckoutPageManager {
        constructor() {
            this.form = Utils.$('#checkoutForm');
            this.placeOrderBtn = Utils.$('#btnPlaceOrder');
            this.init();
        }

        init() {
            // Checkout page data is now rendered by Laravel backend
            // No need to fetch from API or localStorage
            this.bindEvents();
            this.prefillCheckoutInfo();
        }

        bindEvents() {
            if (this.placeOrderBtn) {
                this.placeOrderBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.handlePlaceOrder();
                });
            }
        }

        handlePlaceOrder() {
            if (!this.form) return;

            const data = new FormData(this.form);
            const fullName = data.get('fullName')?.toString().trim();
            const phone = data.get('phone')?.toString().trim();
            const address = data.get('address')?.toString().trim();
            const email = data.get('email')?.toString().trim();
            const payment = data.get('payment');

            // Validate basic information
            if (!fullName || !phone || !address) {
                window.notificationManager?.show('Vui lòng nhập đầy đủ họ tên, số điện thoại và địa chỉ', 'warning');
                return;
            }

            // If payment method not supported yet
            if (payment === "bank" || payment === "wallet") {
                window.notificationManager?.show('Tính năng đang phát triển, vui lòng chọn COD.', 'warning');
                return;
            }

            // Save checkout info
            const info = { fullName, phone, email, address, payment };
            Storage.set(CONFIG.STORAGE_KEYS.CHECKOUT_INFO, info);

            // Process order (COD) - Simplified for demo
            this.showLoading('Đang đặt hàng...');
            setTimeout(() => {
                this.hideLoading();
                const orderId = 'DH' + Math.random().toString(36).slice(2, 8).toUpperCase();
                window.notificationManager?.show(`Đặt hàng thành công! Mã đơn: ${orderId}`, 'success');
                setTimeout(() => { window.location.href = '/'; }, 1200);
            }, 1000);
        }

        prefillCheckoutInfo() {
            try {
                const saved = Storage.get(CONFIG.STORAGE_KEYS.CHECKOUT_INFO);
                if (saved && this.form) {
                    const map = {
                        fullName: 'fullName',
                        phone: 'phone',
                        email: 'email',
                        address: 'address'
                    };
                    Object.keys(map).forEach(k => {
                        const input = this.form.querySelector(`[name="${map[k]}"]`);
                        if (input && saved[k]) input.value = saved[k];
                    });
                    if (saved.payment) {
                        const radio = this.form.querySelector(`input[name="payment"][value="${saved.payment}"]`);
                        if (radio) radio.checked = true;
                    }
                }
            } catch (error) {
                console.error('Error prefill checkout info:', error);
            }
        }

        showLoading(text = 'Đang tải...') {
            // Simple loading implementation
            const loader = document.createElement('div');
            loader.id = 'checkout-loader';
            loader.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
            `;
            loader.innerHTML = `
                <div style="text-align: center;">
                    <div style="width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 15px;"></div>
                    <div>${text}</div>
                </div>
            `;
            document.body.appendChild(loader);
        }

        hideLoading() {
            const loader = Utils.$('#checkout-loader');
            if (loader) loader.remove();
        }
    }

    // ========================================
    // GLOBAL FUNCTIONS FOR BACKWARD COMPATIBILITY
    // ========================================
    window.notify = function(message, type = 'success', duration = 3000) {
        if (window.notificationManager) {
            window.notificationManager.show(message, type, duration);
        } else {
            alert(message);
        }
    };

    window.viewProductDetail = function(productId, productName, price, category) {
        // Store product data in sessionStorage for product page
        const productData = {
            id: productId,
            name: productName,
            price: price,
            category: category,
            timestamp: Date.now()
        };
        
        try {
            sessionStorage.setItem('selectedProduct', JSON.stringify(productData));
        } catch (error) {
            console.error('Error storing product data:', error);
        }
        
        // Navigate to product detail page
        window.location.href = '/product';
    };

    // ========================================
    // INITIALIZATION
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize managers
        window.notificationManager = new NotificationManager();
        window.menuSyncManager = new MenuSyncManager();
        
        // Initialize page-specific managers
        const currentPage = window.location.pathname.split('/').pop() || 'welcome';
        
        if (currentPage === 'product' || window.location.pathname.includes('product')) {
            window.productPageManager = new ProductPageManager();
        }
        
        if (currentPage === 'checkout' || window.location.pathname.includes('checkout')) {
            window.checkoutPageManager = new CheckoutPageManager();
        }
        
        // Initialize slider on all pages
        window.sliderManager = new SliderManager();
        
        // Add global styles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
            
            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }
            
            .notification-content {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .notification-close {
                background: none;
                border: none;
                color: white;
                cursor: pointer;
                padding: 0;
                margin-left: auto;
                opacity: 0.7;
                transition: opacity 0.3s;
            }
            
            .notification-close:hover {
                opacity: 1;
            }
            
            .search-suggestions {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                z-index: 1000;
                display: none;
            }
            
            .search-suggestions.show {
                display: block;
            }
            
            .search-suggestion-item {
                padding: 10px 15px;
                cursor: pointer;
                border-bottom: 1px solid #eee;
            }
            
            .search-suggestion-item:hover {
                background: #f5f5f5;
            }
            
            .search-suggestion-item:last-child {
                border-bottom: none;
            }
        `;
        document.head.appendChild(style);
    });

    // Export for module usage
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = {
            Utils,
            Storage,
            NotificationManager,
            MenuSyncManager,
            SliderManager,
            ProductPageManager,
            CheckoutPageManager
        };
    }

})();
