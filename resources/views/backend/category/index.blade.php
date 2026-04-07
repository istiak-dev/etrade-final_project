@extends('layouts.BackendLayout')
@section('backend_cnt')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <table class="table table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="category-table" data-url="{{ route('admin.category.search') }}">
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <img width="80px" src="{{ getImage($category->icon) }}"
                                                alt="{{ $category->title }}">
                                            {{ $category->title }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.category.show', $category->id) }}">Edit</a>
                                            <a href="{{ route('admin.category.delete', $category->id) }}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">{{ request()->id ? 'Edit' : 'Add' }} Category</div>
                        <div class="card-body">

                            <form enctype="multipart/form-data"
                                action="{{ request()->id ? route('admin.category.update', request()->id) : route('admin.category.store') }}"
                                method="POST">
                                @csrf
                                <div class="form-group my-2">
                                    <label class="d-block">Category Title <span class="text-danger">*</span></label>
                                    <input value="{{ $categories->where('id', request()->id)->first()->title ?? '' }}"
                                        type="text" placeholder="eg: Electronics, Fashion..." class="form-control"
                                        name="title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group my-2">
                                    @if (request()->id && $categories->where('id', request()->id)->first()->icon)
                                        <img width="80px"
                                            src="{{ getImage($categories->where('id', request()->id)->first()->icon) }}"
                                            alt="">
                                    @endif
                                    <label class="d-block">Category Icon</label>
                                    <input type="file" class="form-control" name="icon">
                                    @error('icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary"
                                    type="submit">{{ request()->id ? 'Update' : 'Submit' }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(function() {
            $('input.backend_search').keyup(function() {
                let value = $(this).val()
                $.ajax({
                    url: `{{ route('admin.category.search') }}`,
                    method: 'GET',
                    data: {
                        search: value
                    },
                    success: function(res) {

                        let categoryArray = []

                        res.data.forEach((category, key) => {
                            let editRoute = `{{ route('admin.category.show', 'id_placeholder') }}`
                                editRoute = editRoute.replace('id_placeholder', category.id)
                            let deleteRoute = `{{ route('admin.category.delete', 'id_placeholder') }}`
                                deleteRoute = deleteRoute.replace('id_placeholder', category.id)
                                
                            let imgSrc = `{{getImage('img_path')}}`
                            let placeholder = `{{getImage('')}}`
                            let getImage = category.icon ? imgSrc.replace('img_path', category.icon) : placeholder;

                            categoryHtml = `<tr>
                                    <td>${ ++key }</td>
                                    <td>
                                        <img width="80px" src="${ getImage }" alt="${ category.title }">
                                        ${ category.title }</td>
                                    <td>
                                        <a href="${editRoute}">Edit</a>
                                        <a href="${deleteRoute}">Delete</a>
                                    </td>
                                </tr>`

                                categoryArray.push(categoryHtml);
                        });
                        $('#category-table').html(categoryArray)
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })

            })
        })
    </script>
@endpush
