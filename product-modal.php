<!-- Product Quick View Modal -->
<div class="modal fade" id="viewproduct-over" tabindex="-1" role="dialog" aria-labelledby="add-payment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="view-product">
            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="sp-wrap">
                            <img src="" class="img-fluid product-image" alt="">
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="woo_pr_detail">
                            <div class="woo_cats_wrps">
                                <a href="#" class="woo_pr_cats category-name"></a>
                            </div>
                            <h2 class="woo_pr_title product-name"></h2>
                            
                            <div class="woo_pr_price">
                                <div class="woo_pr_offer_price">
                                    <h3 class="product-price"></h3>
                                </div>
                            </div>
                            
                            <div class="woo_pr_short_desc">
                                <p class="product-description"></p>
                            </div>
                            
                            <div class="woo_btn_action">
                                <div class="col-12 col-lg-auto">
                                    <input type="number" class="form-control mb-2 full-width quantity-input" value="1" min="1">
                                </div>
                            </div>
                            
                            <div class="woo_btn_action">
                                <div class="col-12 col-lg-auto">
                                    <button type="button" class="btn btn-block btn-dark mb-2 add-to-cart-btn">
                                        Add to Cart <i class="ti-shopping-cart-full ml-2"></i>
                                    </button>
                                </div>
                                <div class="col-12 col-lg-auto">
                                    <button type="button" class="btn btn-gray btn-block mb-2 add-to-wishlist-btn">
                                        <i class="ti-heart"></i> Add to Wishlist
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Scripts -->
<script>
// Function to update modal content
function updateProductModal(productData) {
    const modal = $('#viewproduct-over');
    
    // Update product details
    modal.find('.product-image').attr('src', productData.image);
    modal.find('.category-name').text(productData.category);
    modal.find('.product-name').text(productData.name);
    modal.find('.product-price').html('₹' + productData.price);
    modal.find('.product-description').text(productData.description);
    
    // Set product ID for add to cart and wishlist buttons
    modal.find('.add-to-cart-btn').attr('data-product-id', productData.id);
    modal.find('.add-to-wishlist-btn').attr('data-product-id', productData.id);
    
    // Check if product is in wishlist
    checkWishlistStatus(productData.id);
}

// Function to check wishlist status
function checkWishlistStatus(productId) {
    $.ajax({
        url: 'check-wishlist-status.php',
        type: 'POST',
        data: { product_id: productId },
        dataType: 'json',
        success: function(response) {
            const wishlistBtn = $('.add-to-wishlist-btn');
            if (response.in_wishlist) {
                wishlistBtn.addClass('active').html('<i class="ti-heart"></i> In Wishlist');
            } else {
                wishlistBtn.removeClass('active').html('<i class="ti-heart"></i> Add to Wishlist');
            }
        }
    });
}

// Add to cart handler
$('.add-to-cart-btn').click(function() {
    const productId = $(this).data('product-id');
    const quantity = $('.quantity-input').val();
    
    $.ajax({
        url: 'add-to-cart.php',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: quantity
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showNotification('Product added to cart successfully', 'success');
            } else {
                showNotification(response.message || 'Failed to add product to cart', 'error');
            }
        },
        error: function() {
            showNotification('Error adding product to cart', 'error');
        }
    });
});

// Add to wishlist handler
$('.add-to-wishlist-btn').click(function() {
    const productId = $(this).data('product-id');
    const btn = $(this);
    
    $.ajax({
        url: 'add-to-wishlist.php',
        type: 'POST',
        data: { product_id: productId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                btn.addClass('active').html('<i class="ti-heart"></i> In Wishlist');
                showNotification('Product added to wishlist successfully', 'success');
            } else {
                showNotification(response.message || 'Failed to add product to wishlist', 'error');
            }
        },
        error: function() {
            showNotification('Error adding product to wishlist', 'error');
        }
    });
});

// Notification function
function showNotification(message, type) {
    const notification = $('<div class="notification ' + type + '">' + message + '</div>');
    $('body').append(notification);
    setTimeout(() => {
        notification.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}
</script>

<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    border-radius: 5px;
    color: white;
    z-index: 9999;
    animation: slideIn 0.3s ease-out;
}

.notification.success {
    background-color: #28a745;
}

.notification.error {
    background-color: #dc3545;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.add-to-wishlist-btn.active {
    background-color: #dc3545;
    color: white;
}

.add-to-wishlist-btn.active i {
    color: white;
}
</style> 