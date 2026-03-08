@extends('dashbord.layouts.master')

@section('title', 'إضافة طلب جديد')

@section('admin_content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>إضافة طلب جديد</h1>
    </section>

    <section class="content">
        <div class="card card-primary">
            @if($products->isEmpty())
                <div class="alert alert-warning m-3">
                    لا توجد منتجات متاحة. الرجاء إضافة منتجات أولًا.
                </div>
            @else
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    <!-- اختيار الطاولة -->
                    <div class="form-group mb-3">
                        <label>اختر الطاولة:</label>

                        <select name="table_id" class="form-select">
                                <option value="">اختر الطاولة</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                        {{ $table->number }} ({{ $table->min_guests }} - {{ $table->max_guests }} أشخاص)
                                    </option>
                                @endforeach
                            </select>

                    </div>


                    <!-- الأصناف -->
                    <h5>الأصناف:</h5>
                    <div id="order-items">
                        <div class="order-item mb-2 d-flex gap-2 align-items-center">
                            <select name="items[0][product_id]" class="form-select product-select" data-index="0">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} - {{ $product->price }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="number" name="items[0][quantity]" class="form-control" value="1" min="1">

                            <input type="hidden" name="items[0][price]" class="item-price" value="{{ $products->first()?->price ?? 0 }}">

                            <button type="button" class="btn btn-danger btn-sm remove-item">حذف</button>
                        </div>
                    </div>

                    <button type="button" id="add-item" class="btn btn-success mb-3">إضافة صنف جديد</button>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">إضافة الطلب</button>
                </div>
            </form>
            @endif
        </div>
    </section>
</div>

<script>
let itemIndex = 1;

function attachEvents(item) {
    const select = item.querySelector('.product-select');
    const priceInput = item.querySelector('.item-price');

    select.addEventListener('change', function(){
        priceInput.value = select.selectedOptions[0].dataset.price;
    });

    item.querySelector('.remove-item').addEventListener('click', function(){
        item.remove();
    });
}

// للأصناف الموجودة
document.querySelectorAll('.order-item').forEach(attachEvents);

// إضافة صنف جديد
document.getElementById('add-item')?.addEventListener('click', function(){
    const container = document.getElementById('order-items');
    const newItem = document.createElement('div');
    newItem.classList.add('order-item', 'mb-2', 'd-flex', 'gap-2', 'align-items-center');

    newItem.innerHTML = `
        <select name="items[${itemIndex}][product_id]" class="form-select product-select" data-index="${itemIndex}">
            @foreach($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                    {{ $product->name }} - {{ $product->price }}
                </option>
            @endforeach
        </select>
        <input type="number" name="items[${itemIndex}][quantity]" class="form-control" value="1" min="1">
        <input type="hidden" name="items[${itemIndex}][price]" class="item-price" value="{{ $products->first()?->price ?? 0 }}">
        <button type="button" class="btn btn-danger btn-sm remove-item">حذف</button>
    `;

    container.appendChild(newItem);
    attachEvents(newItem);
    itemIndex++;
});
</script>
@endsection
