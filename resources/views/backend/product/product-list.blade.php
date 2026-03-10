@extends('layouts.BackendLayout')
@section('backend_cnt')
    <div class="card border border-light border-2 rounded-3 mb-4">
        <h4 class="card-header">Product List</h4>
        <div class="table-responsive text-nowrap">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <table class="table table-responsive table-striped pb-5">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>P.Name</th>
                        <th>p.image</th>
                        <th>Catagory</th>
                        <th>Slug</th>
                        <th>Regular Price</th>
                        <th>Sale Price</th>
                        <th>Daily Deal</th>
                        <th>Sku</th>
                        <th>Stock</th>
                        <th>Brand Name</th>
                        <th>Model</th>
                        <th>Publish Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($products as $key => $product)
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

                                        <button
                                            class="btn btn-sm {{ ($product->deal_status ?? 0) == 1 ? ($product->deal_date && !(date('Y-m-d', strtotime($product->deal_date)) < date('Y-m-d')) ? 'btn-danger' : 'btn-secondary') : ($product->deal_date && !(date('Y-m-d', strtotime($product->deal_date)) < date('Y-m-d')) ? 'btn-info' : 'btn-secondary') }}"
                                            {{ $product->deal_date && !(date('Y-m-d', strtotime($product->deal_date)) < date('Y-m-d')) ? '' : 'disabled' }}>
                                            {{ ($product->deal_status ?? 0) == 1 ? 'Suspend' : 'Resume' }}
                                        </button>
                                    </form>

                                    <a href="#staticBackdrop{{ $product->id }}" class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal">+Set
                                        Deal</a>
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
                                        <a class="dropdown-item"
                                            href="{{ route('admin.product.add', $product->id) }}"><i
                                                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.product.deleteproduct', $product->id) }}"><i
                                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop{{ $product->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <form action="{{ route('admin.product.updateproduct', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Schedule deal</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <label for="dealDate" class="mb-2">Choose Date</label>

                                            <input type="date" name="deal_date" id="dealDate" class="form-control"
                                                min="{{ date('Y-m-d') }}"
                                                value="{{ old('id') == $product->id ? old('deal_date') : $product->deal_date }}">

                                            {{-- to find the product from list when modal destroyed after clicking submit or, set button --}}
                                            <input type="hidden" name="id" value="{{ $product->id }}">

                                            @error('deal_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Set</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('js')
    @if ($errors->has('deal_date'))
        <script>
            $(function() {
                // daily deal modal show on validation error
                bootstrap.Modal.getOrCreateInstance('#staticBackdrop{{ old('id') }}').show();
            })
        </script>
    @endif
@endpush
