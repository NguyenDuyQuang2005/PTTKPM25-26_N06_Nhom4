@php
    // Lấy tất cả comment của sản phẩm
    $comments = $product->comments;
    $totalComments = $comments->count();
    
    // Tính trung bình rating
    $averageRating = $totalComments > 0 ? round($comments->avg('rating'), 1) : 0;
    
    // Đếm số lượng từng loại rating
    $rating5 = $comments->where('rating', 5)->count();
    $rating4 = $comments->where('rating', 4)->count();
    $rating3 = $comments->where('rating', 3)->count();
    $rating2 = $comments->where('rating', 2)->count();
    $rating1 = $comments->where('rating', 1)->count();
    
    // Tính % cho mỗi rating
    $percent5 = $totalComments > 0 ? round(($rating5 / $totalComments) * 100) : 0;
    $percent4 = $totalComments > 0 ? round(($rating4 / $totalComments) * 100) : 0;
    $percent3 = $totalComments > 0 ? round(($rating3 / $totalComments) * 100) : 0;
    $percent2 = $totalComments > 0 ? round(($rating2 / $totalComments) * 100) : 0;
    $percent1 = $totalComments > 0 ? round(($rating1 / $totalComments) * 100) : 0;
@endphp
 <div class="container">
            <div class="tabs-header">
                <div class="tab-buttons">
                    <button class="tab-button active" data-tab="description">
                        <i class="fas fa-info-circle"></i>
                        <span>Mô tả sản phẩm</span>
                    </button>
                    <button class="tab-button" data-tab="reviews">
                        <i class="fas fa-star"></i>
                        <span>Đánh giá & Bình luận</span>
                        <span class="review-count">({{ $totalComments }})</span>
                    </button>
                </div>
            </div>

            <div class="tab-content active" id="description" style="white-space: pre-line;">
               {{$product->content}}
            </div>

            <div class="tab-content" id="reviews">
                <div class="reviews-summary">
                    <div class="reviews-header">
                        <h3>Đánh giá sản phẩm</h3>
                        <div class="reviews-stats">
                        <span class="total-reviews">{{ $totalComments }} đánh giá</span>
                        <span class="average-rating">{{ $averageRating }}/5</span>
                        </div>
                    </div>
                    <div class="rating-overview">
                        <div class="rating-score">
                            <span class="score">{{ $averageRating }}</span>
                            <div class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($averageRating))
                                        <i class="fas fa-star"></i>
                                    @elseif ($i - $averageRating < 1)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p>Dựa trên {{ $totalComments }} đánh giá</p>
                            <div class="rating-distribution">
                                <div class="rating-bar"></div>
                                    <span>5 sao</span>
                                    <div class="bar">
                                        <div class="fill" style="width: {{ $percent5 }}%;"></div>
                                    </div>
                                    <span>{{ $percent5 }}%</span>
                                </div>
                                <div class="rating-bar">
                                    <span>4 sao</span>
                                    <div class="bar">
                                        <div class="fill" style="width: {{ $percent4 }}%;"></div>
                                    </div>
                                    <span>{{ $percent4 }}%</span>
                                </div>
                                <div class="rating-bar">
                                    <span>3 sao</span>
                                    <div class="bar">
                                        <div class="fill" style="width: {{ $percent3 }}%;"></div>
                                    </div>
                                    <span>{{ $percent3 }}%</span>
                                </div>
                                <div class="rating-bar">
                                    <span>2 sao</span>
                                    <div class="bar">
                                        <div class="fill" style="width: {{ $percent2 }}%;"></div>
                                    </div>
                                    <span>{{ $percent2 }}%</span>
                                    </div>
                                <div class="rating-bar">
                                    <span>1 sao</span>
                                    <div class="bar">
                                        <div class="fill" style="width: {{ $percent1 }}%;"></div>
                                    </div>
                                    <span>{{ $percent1 }}%</span>   
                                    </div>

                        </div>
                      
                    </div>
                </div>
                
                <div class="reviews-list">
                    <div class="reviews-controls">
                        <h4>Bình luận của khách hàng</h4>
                        <div class="reviews-filters">
                            <select class="filter-select">
                                <option value="all">Tất cả đánh giá</option>
                                <option value="5">5 sao</option>
                                <option value="4">4 sao</option>
                                <option value="3">3 sao</option>
                                <option value="2">2 sao</option>
                                <option value="1">1 sao</option>
                            </select>
                            <select class="sort-select">
                                <option value="newest">Mới nhất</option>
                                <option value="oldest">Cũ nhất</option>
                                <option value="highest">Đánh giá cao</option>
                                <option value="lowest">Đánh giá thấp</option>
                            </select>
                        </div>
                    </div>
                    <!-- chỉ khi đăng nhập thì mới được xóa -->
                   <div class="reviews-container">
                  @forelse($comments as $comment)
                  <div class="review-item" data-rating="{{ $comment->rating }}">
                   <div class="review-header">
                    <div class="reviewer-info">
                     <img src="{{asset('frontend/asset/images/User.png')}}" alt="{{ $comment->author ? $comment->author->name : 'Khách' }}">
                      <div>
                         <h5>{{ $comment->author ? $comment->author->name : 'Khách' }}</h5>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $comment->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                      </div>
                    </div>
                <div class="review-meta">
                  <span class="review-date">{{ $comment->created_at->format('d/m/Y') }}</span>
                <div class="review-actions">
                        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->id() === $comment->author_id))
                            <form action="{{ route('comment.destroy', $comment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #dc3545; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer;">
                                    Xóa
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
           <p class="review-content">{{ $comment->content }}</p>
              </div>
              @empty
                        <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="far fa-comments" style="font-size: 48px; margin-bottom: 15px;"></i>
                        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                        <p>Hãy là người đầu tiên đánh giá!</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="load-more-reviews">
                        <button class="btn-load-more">
                            <i class="fas fa-plus"></i>
                            Xem thêm đánh giá
                        </button>
                    </div>
                <!-- viet danh gia o day -->
                    <div class="review-from">
                        <h4>Viết đánh giá của bạn</h4>
                        @if(session('success'))
                        <div style="backgound: #d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px;">
                        <i class="fas fa-check-circle"></i>    
                        {{ session('success') }}   
                        </div>
                        @endif
                        @if($errors->any())
                        <div style ="background:#f8d7da; color:#721c24; padding:20px; border-radius:5px; margin-bottom:15px;">
                            <ul style ="margin:0 ;padding-left:20px">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('comment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="rating" id="rating-value" value="5">
                            <div class="from-group">
                                <label for="rating">Đánh giá của bạn:</label>
                                <div class="star-rating" id="star-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="far fa-star" data-value="{{ $i }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="from-group"></div>
                                <label for="comment" style="display:block; margin-top:10px;">Bình luận:*</label>
                                <textarea name="content" id="content" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn-submit-review">Gửi đánh giá</button>
                        </form>
                    </div>                              
                </div>
            </div>
        </div>
    </section>

    <!---------------------------------Related Products Section------------------------------------->
    <section class="related-products">
        <div class="container">
            <h2 class="section-title">Sản Phẩm Nổi Bật</h2>
            <div class="products-grid">
               @foreach($products as $product)
                <div class="product-item" data-product-id="book1" data-price="150000">
                    <a href="   "><img src="{{asset($product ->image)}}" alt="Tấm Cám - Truyện Cổ Tích"><a>
                    <h4><a href="/product/{{$product ->id}}">{{$product ->name}}</a></h4>
                    <p style="font-size: 12px">MSP: {{$product ->masanpham}}</p>
                    <div class="price">
                        <p><span class="new-price">{{$product ->price_sale}}<sup>đ</sup></span> <span class="old-price">{{$product ->price_normal}}<sup>đ</sup></span></p>
                    </div>
                    <div class="product-actionss">  
                       <a href="/product/{{$product ->id}}"> <button class="btn btn-primary btn-view-detail">Xem chi tiết</button></a>
                        <form action="/cart/add" method="post" style="display:inline-block">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <input type="hidden" name="product_qty" value="1">
                            <button type="submit" class="btn btn-secondary">Thêm Vào Giỏ</button>
                        </form>
                    </div>
                </div>
               @endforeach
            </div>
        </div>