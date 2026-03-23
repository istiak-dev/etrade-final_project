@extends('layouts.BackendLayout')
@section('backend_cnt')
    <div class="card border border-light border-2 rounded-3 mb-4">
        <h4 class="card-header">Product List</h4>
        <div class="table-responsive text-nowrap">

            <table class="table table-responsive table-striped pb-5">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>P.Name</th>
                        <th>p.image</th>
                        <th>Catagory</th>
                        <th>Slug</th>
                        <th>Price</th>
                        <th>Sale Price</th>
                        <th>Daily Deal</th>
                        <th>Sku</th>
                        <th>Stock</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Pub. Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="product-table">
                    @forelse ($products as $key => $product)
                        <tr>

                            <td>{{ ++$key }} </td>
                            <td>{{ $product->title }}</td>
                            <td>
                                <img width="80px" src="{{ getImage($product->image) }}" alt="{{ $product->title }}">
                            </td>
                            <td>{{ $categories->where('id', $product->category_id)->first()->title ?? 'No Category' }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td>
                                <div class="deal-show mb-1">
                                    @if ($product->deal_date)
                                        @if (isset($product->deal_status) && $product->deal_status == 0)
                                            <span class="text-warning">
                                                {{ date('Y-m-d', strtotime($product->deal_date)) }} (Suspended!)
                                            </span>
                                        @elseif (date('Y-m-d', strtotime($product->deal_date)) > date('Y-m-d'))
                                            <span class="text-info">
                                                {{ date('Y-m-d', strtotime($product->deal_date)) }} (Upcoming)
                                            </span>
                                        @elseif (date('Y-m-d', strtotime($product->deal_date)) == date('Y-m-d'))
                                            <span class="text-primary">
                                                {{ date('Y-m-d', strtotime($product->deal_date)) }} (Running)
                                            </span>
                                        @else
                                            <span class="text-danger">
                                                {{ date('Y-m-d', strtotime($product->deal_date)) }} (Expired)
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted">No Deal</span>
                                    @endif
                                </div>

                                <div class="d-flex gap-2 align-items-center">
                                    <form action="{{ route('admin.product.updateproduct', $product->id) }}" method="POST"
                                        class="">
                                        @csrf
                                        <input type="hidden" name="deal_status"
                                            value="{{ ($product->deal_status ?? 0) == 1 ? 0 : 1 }}">

                                        <button class="btn btn-sm {{ dealBtnClr($product) }}"
                                            {{ $product->deal_date && date('Y-m-d', strtotime($product->deal_date)) >= date('Y-m-d') ? '' : 'disabled' }}>
                                            {{ ($product->deal_status ?? 0) == 1 ? 'Suspend' : 'Resume' }}
                                        </button>
                                    </form>

                                    <a href="#staticBackdrop" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        id="setDeal"
                                        onclick="
                                        $('#dealForm').attr('action', '{{ route('admin.product.updateproduct', $product->id) }}') 
                                        $('#dealDate').attr('min', '{{ date('Y-m-d') }}' )
                                        $('#dealDate').val('{{ old('id') == $product->id ? old('deal_date') : $product->deal_date }}')
                                        $('input#productId').val('{{ $product->id }}')">
                                        +Set Deal
                                    </a>
                                </div>
                            </td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->brand_name }}</td>
                            <td>{{ $product->model }}</td>
                            <td>{{ $product->published_status }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.product.add', $product->id) }}"><i
                                                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.product.deleteproduct', $product->id) }}"><i
                                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="19" class="border-0">
                                <div class="empty-state text-center pt-4">
                                    <div class="mb-3">
                                        <i class="icon-base bx bx-package bx-lg text-secondary"></i>
                                    </div>

                                    <h5 class="text-muted fw-semibold">No Products Found</h5>
                                    <p class="text-muted mb-4">It looks like you haven't added any products yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="dealForm" action="{{ old('id') ? route('admin.product.updateproduct', old('id')) : '' }}"
                    method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Schedule deal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <label for="dealDate" class="mb-2">Choose Date</label>

                        <input type="date" name="deal_date" id="dealDate" class="form-control" min=""
                            value="">

                        {{-- to find the product from list when modal destroyed after clicking submit or, set button --}}
                        <input type="hidden" id="productId" name="id" value="{{ old('id') }}">

                        @error('deal_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Set</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {

            $('input.backend_search').keyup(function() {

                const value = $(this).val()

                $.ajax({
                    url: `{{ route('admin.product.search') }}`,
                    method: 'GET',
                    data: {
                        search: value
                    },
                    success: function(res) {

                        let productArray = []

                        res.data.forEach((product, key) => {

                            
                            // pre-defined route & path
                            let dealRoute = `{{ route('admin.product.updateproduct', 'id_placeholder') }}`
                            let dealStatRoute = dealRoute.replace('id_placeholder', product.id)
                            let dealDateRoute = dealRoute.replace('id_placeholder',product.id)
                            
                            let editRoute = `{{ route('admin.product.add', 'id_placeholder') }}`
                                editRoute = editRoute.replace('id_placeholder', product.id)
                            let deleteRoute = `{{ route('admin.product.deleteproduct', 'id_placeholder') }}`
                                deleteRoute = deleteRoute.replace('id_placeholder', product.id)

                            // getImage logic
                            let imgSrc = `{{ getImage('img_path') }}`
                            let placeholder = `{{ getImage('') }}`
                            let getImage = product.image ? imgSrc.replace('img_path', product.image) : placeholder;

                            // deal status variables
                            const today = new Date().toISOString().split('T')[0];
                            let activeDeal = (product.deal_status == 1)
                            const dealDate = product.deal_date ? new Date(product.deal_date).toISOString().split('T')[0] : null;
                            let validDate = (product.deal_date && (dealDate >= today))
                            let dealBtnClr = (!validDate) ? 'btn-secondary' : (activeDeal ? 'btn-danger' : 'btn-info');
                            
                            // deal badge
                            let dealBadge = '<span class="text-muted">No Deal</span>';
                            
                            if (product.deal_date) {
                                if (product.deal_status == 0) {
                                    dealBadge =
                                        `<span class="text-warning">${dealDate} (Suspended!)</span>`;
                                } else if (dealDate > today) {
                                    dealBadge =
                                        `<span class="text-info">${dealDate} (Upcoming)</span>`;
                                } else if (dealDate == today) {
                                    dealBadge =
                                        `<span class="text-primary">${dealDate} (Running)</span>`;
                                } else {
                                    dealBadge =
                                        `<span class="text-danger">${dealDate} (Expired)</span>`;
                                }
                            }

                            // product html structure
                            let productHTML = `<tr>

                            <td>${++key}</td>
                            <td>${product.title}</td>
                            <td>
                                <img width="80px" src="${getImage}" alt="${product.title}">
                            </td>
                            <td>${product.category ? product.category.title : 'No Category'}</td>
                            <td>${product.slug}</td>
                            <td>${product.price}</td>
                            <td>${product.sale_price}</td>
                            <td>
                                <div class="deal-show mb-1">${dealBadge}</div>

                                <div class="d-flex gap-2 align-items-center">
                                    <form action="${dealStatRoute}" method="POST"
                                        class="">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="deal_status"
                                            value="${activeDeal ? 0 : 1}">

                                        <button class="btn btn-sm ${dealBtnClr}" ${validDate ? '' : 'disabled'}>
                                            ${activeDeal ? 'Suspend' : 'Resume'}
                                        </button>
                                    </form>

                                    <a href="#staticBackdrop" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        id="setDeal"
                                        onclick="
                                        $('#dealForm').attr('action', '${dealDateRoute}')
                                        $('#dealDate').attr('min', '${today}' )
                                        $('#dealDate').val('${"{{ old('id') ?? '' }}" == product.id ? "{{ old('deal_date') ?? '' }}" : (product.deal_date || '')}')
                                        $('input#productId').val('${product.id}')">
                                        +Set Deal
                                    </a>
                                </div>
                            </td>
                            <td>${product.sku}</td>
                            <td>${product.stock}</td>
                            <td>${product.brand_name}</td>
                            <td>${product.model}</td>
                            <td>${product.published_status}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="${editRoute}"><i
                                                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item"
                                            href="${deleteRoute}"><i
                                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>`

                            productArray.push(productHTML)
                        });
                        $('#product-table').html(productArray)

                    },
                    error: function(err) {
                        console.log(err);
                    },
                })
            })
        })
    </script>
    @if ($errors->has('deal_date'))
        <script>
            $(function() {
                // daily deal modal show on validation error
                bootstrap.Modal.getOrCreateInstance('#staticBackdrop').show();
            })
        </script>
    @endif
@endpush
