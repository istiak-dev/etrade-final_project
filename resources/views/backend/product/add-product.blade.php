@extends('layouts.BackendLayout')
@section('backend_cnt')
<div class="heading pb-4">
    <h2>{{ isset($editProduct) ? 'Edit Product' : 'Add New Product' }}</h2>
    <p>{{ isset($editProduct) ? 'Edit product and store' : 'Add a new product to your store' }} </p>
</div>
<form
    action="{{ isset($editProduct) ? route('admin.product.updateproduct', $editProduct->id) : route('admin.product.storproduct') }}"
    enctype="multipart/form-data" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card border border-light border-2 rounded-3 mb-4">
                <h4 class="card-header">Name and Description</h4>
                <hr class="p-0 m-0">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="productName" class="form-label">Prodact Name/Title</label>
                        <input value="{{ $products->where('id', request()->id)->first()->title ?? '' }}" type="text"
                            class="form-control" id="productName" name="title"
                            aria-describedby="defaultFormControlHelp" />
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="productSlug" class="form-label">Product Slug</label>
                        <input value="{{ $products->where('id', request()->id)->first()->slug ?? '' }}" type="text"
                            class="form-control" id="productSlug" name="slug"
                            aria-describedby="defaultFormControlHelp" />
                        @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="productShortDescription" class="form-label">Prodact Short Description</label>
                        <input value="{{ $products->where('id', request()->id)->first()->short_description ?? '' }}"
                            type="text" class="form-control" id="productShortDescription" name="short_description"
                            aria-describedby="defaultFormControlHelp" />
                        @error('short_description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="productDescription" class="form-label">Product Description</label>
                        <textarea value="{{ $products->where('id', request()->id)->first()->description ?? '' }}"
                            class="form-control" id="productDescription" rows="5" name="description"></textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card border border-light border-2 rounded-3 mb-4">
                <h4 class="card-header">Catagory</h4>
                <hr class="p-0 m-0">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="catagorySelect" class="form-label">Product Catagory</label>
                        <select class="form-select" name="category_id" id="catagorySelect"
                            aria-label="Default select example">
                            @forelse ($categories as $category)
                            <option selected disabled>Please select a Cagtegory</option>
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @empty
                            <option selected disabled>Please add Cagtegory</option>
                            @endforelse
                        </select>

                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                </div>
            </div>
            <div class="card border border-light border-2 rounded-3 mb-4">
                <h4 class="card-header">Inventory</h4>
                <hr class="p-0 m-0">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="sku" class="form-label">Stock Kepping Unit</label>
                        <input value="{{ $products->where('id', request()->id)->first()->sku ?? '' }}" type="text"
                            class="form-control" id="sku" name="sku" aria-describedby="defaultFormControlHelp" />
                        @error('sku')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <label for="productStock" class="form-label">Product Stock</label>
                            <input value="{{ $products->where('id', request()->id)->first()->stock ?? '' }}"
                                type="number" class="form-control" id="productStock" name="stock"
                                aria-describedby="defaultFormControlHelp" />
                            @error('stock')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-12">
                            <label for="productMiniumstock" class="form-label">Minium Stock</label>
                            <input value="{{ $products->where('id', request()->id)->first()->minstock ?? '' }}"
                                type="number" class="form-control" id="productMiniumstock" name="minstock"
                                aria-describedby="defaultFormControlHelp" />
                            @error('minstock')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4 col-lg-4 col-12">
                            <label for="catagoryStatus" class="form-label">Product Status</label>
                            <select class="form-select" name="stock_status" id="catagoryStatus" aria-label="Default select example">
                                <option value="1"  selected>In Stock</option>
                                <option value="0" >Out Of Stock</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card border border-light border-2 rounded-3 mb-4">
                <h4 class="card-header">Product Details</h4>
                <hr class="p-0 m-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <label for="brand" class="form-label">Brand Name</label>
                            <input value="{{ $products->where('id', request()->id)->first()->brand_name ?? '' }}"
                                type="text" class="form-control" id="brand" name="bname"
                                aria-describedby="defaultFormControlHelp" />
                            @error('bname')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-12">
                            <label for="Model" class="form-label">Model</label>
                            <input value="{{ $products->where('id', request()->id)->first()->model ?? '' }}" type="text"
                                class="form-control" id="Model" name="model"
                                aria-describedby="defaultFormControlHelp" />
                            @error('model')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border border-light border-2 rounded-3 mb-4">
                <h4 class="card-header">Product Pricing</h4>
                <hr class="p-0 m-0">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-6 col-12">
                            <label for="regularPrice" class="form-label">Regular Price</label>
                            <input value="{{ $products->where('id', request()->id)->first()->price ?? '' }}"
                                class="form-control" name="price" type="number" id="Price" />
                            @error('price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-12">
                            <label for="salePrice" class="form-label">Sale Price</label>
                            <input value="{{ $products->where('id', request()->id)->first()->sale_price ?? '' }}"
                                class="form-control" name="sale_price" type="number" id="salePrice" />
                            @error('sale_price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border border-light border-2 rounded-3 mb-4">
                <h4 class="card-header">Product Image</h4>
                <hr class="p-0 m-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <img id="preview" src="" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div>
                        <label for="productimg" class="form-label">Choose Image</label>
                        <input class="form-control form-control-lg" name="image" id="productimg" type="file" />
                        @error('image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row gallleryImg">

                    </div>
                    <div class="mt-4">
                        <label for="gallImges" class="form-label ">Gallery Images</label>
                        <input class="form-control form-control-lg" name="gall_img[]" id="gallImges" type="file"
                            multiple />
                        @error('gall_img[]')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card border border-light border-2 rounded-3 mb-4">
                <h4 class="card-header">Schedule</h4>
                <hr class="p-0 m-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="visibility" class="form-label">Product Visibility</label>
                            <select class="form-select" id="visibility" name="published_status"
                                aria-label="Default select example">
                                <option selected>Published</option>
                                <option>Schedule</option>
                                <option>Hidden</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="publishDate" class="form-label">Publish Date</label>
                            <input value="{{ $products->where('id', request()->id)->first()->published_date ?? '' }}"
                                type="date" class="form-control" id="publishDate" name="publish_date">
                            @error('publish_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-evenly pt-5">
                {{-- <a href="" class="btn btn-primary col-5 p-2"><i class="bx bx-save me-2"></i>Save product</a> --}}
                <button type="submit" class="btn btn-dark col-6 p-2">
                    <i class="bx bx-plus me-2"></i>{{ isset($editProduct) ? 'Edit Product' : 'Add Product' }}
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('js')
<script>
    $(function() {
            $('input[name="title"]').keyup(function() {
                const slug = $(this).val().toLowerCase().replaceAll(' ', '-').replaceAll('@', '')
                    .replaceAll('#', '')
                $('input[name="slug"]').val(slug)
            })

            $('#productimg').change(function() {
                const file = $(this)[0].files[0]
                const url = URL.createObjectURL(file)
                $('#preview').attr('src', url)
            })

            $('#gallImges').on('change', function(e) {
                const previewContainer = $('.gallleryImg');

                Array.from(e.target.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const url = URL.createObjectURL(file);
                        const imgBox = `
                                    <div class="col-4 my-3 position-relative">
                                        <img style="background-size: 100% 100%;"" src="${url}" class="img-fluid rounded shadow img-thumbnail">
                                        <button class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-light text-dark">x</button>
                                    </div>
                                `;
                        previewContainer.append(imgBox);
                    }
                });
            });
            $('.gallleryImg').on('click', '.badge', function() {
                $(this).parent().remove();
            })
        })
</script>
@endpush