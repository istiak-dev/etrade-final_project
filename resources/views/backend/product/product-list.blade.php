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
                            <td>{{ $product->catagory_id }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <form action="" class="">
                                        <button class="btn btn-sm btn-secondary">
                                            Suspend/Resume
                                        </button>
                                    </form>

                                    <a href="#staticBackdrop" class="btn btn-sm btn-primary" data-bs-toggle="modal" >+Set Deal</a>
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
                                            href="{{ route('admin.product.updateproduct', $product->id) }}"><i
                                                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.product.deleteproduct', $product->id) }}"><i
                                                class="icon-base bx bx-trash me-1"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


    {{-- daily deal modal --}}
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Schedule deal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <label for="dealDate" class="mb-2">Choose Date</label>
                        <input type="date" name="deal_date" id="dealDate" class="form-control">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Set</button>
                </div>
            </div>
        </div>
    </div>
@endsection