@extends('layouts.game')

@section('title', 'Cân Táo Cân Cam')

@section('styles')
<style>
    .draggable-item {
        user-select: none;
        -webkit-user-drag: element;
    }
    
    .scale-75 {
        transform: scale(0.75);
    }
    
    #scale {
        perspective: 1000px;
    }
    
    #left-plate, #right-plate {
        transition: transform 0.5s ease;
    }
    
    .items-container {
        min-height: 80px;
    }
</style>
@endsection

@section('game_content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600">Cân Táo Cân Cam 🍎🍊</h1>
        <p class="text-lg mt-2">Kéo các vật lên cân sao cho hai bên cân bằng nhau</p>
    </div>

    <div class="flex justify-center mb-8">
        <div id="scale" class="relative w-[600px] h-[400px]">
            <!-- Cân -->
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
                <div class="w-4 h-[200px] bg-gray-700 mx-auto"></div>
                <div class="w-[400px] h-2 bg-gray-700 -mt-2"></div>
            </div>
            
            <!-- Đĩa trái -->
            <div id="left-plate" class="absolute left-[100px] top-[250px] w-[150px] h-[100px] border-4 border-gray-700 rounded-lg bg-white transition-all duration-500"
                 data-weight="0">
                <div class="text-center mt-2 font-bold total-weight">0g</div>
                <div class="items-container flex flex-wrap justify-center gap-2 p-2 min-h-[60px]"></div>
            </div>

            <!-- Đĩa phải -->
            <div id="right-plate" class="absolute right-[100px] top-[250px] w-[150px] h-[100px] border-4 border-gray-700 rounded-lg bg-white transition-all duration-500"
                 data-weight="0">
                <div class="text-center mt-2 font-bold total-weight">0g</div>
                <div class="items-container flex flex-wrap justify-center gap-2 p-2 min-h-[60px]"></div>
            </div>
        </div>
    </div>

    <!-- Khu vực chứa các vật để kéo -->
    <div id="items-container" class="flex flex-wrap justify-center gap-4 mt-8">
        <div class="draggable-item cursor-move p-2 bg-red-100 rounded-lg text-center" data-weight="300">
            <span class="text-2xl">🍎</span>
            <div class="weight-label text-sm font-bold">300g</div>
        </div>
        <div class="draggable-item cursor-move p-2 bg-orange-100 rounded-lg text-center" data-weight="200">
            <span class="text-2xl">🍊</span>
            <div class="weight-label text-sm font-bold">200g</div>
        </div>
        <div class="draggable-item cursor-move p-2 bg-green-100 rounded-lg text-center" data-weight="500">
            <span class="text-2xl">🍐</span>
            <div class="weight-label text-sm font-bold">500g</div>
        </div>
        <div class="draggable-item cursor-move p-2 bg-red-100 rounded-lg text-center" data-weight="1000">
            <span class="text-2xl">🍉</span>
            <div class="weight-label text-sm font-bold">1kg</div>
        </div>
        <div class="draggable-item cursor-move p-2 bg-yellow-100 rounded-lg text-center" data-weight="400">
            <span class="text-2xl">🍌</span>
            <div class="weight-label text-sm font-bold">400g</div>
        </div>
    </div>

    <!-- Thông báo -->
    <div id="message" class="fixed top-4 right-4 p-4 rounded-lg text-white font-bold hidden"></div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const draggableItems = document.querySelectorAll('.draggable-item');
    const plates = document.querySelectorAll('#left-plate, #right-plate');
    const scale = document.getElementById('scale');
    const messageEl = document.getElementById('message');

    let draggedItem = null;

    // Khởi tạo drag & drop
    draggableItems.forEach(item => {
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragend', handleDragEnd);
        item.setAttribute('draggable', true);
    });

    plates.forEach(plate => {
        plate.addEventListener('dragover', handleDragOver);
        plate.addEventListener('drop', handleDrop);
    });

    function handleDragStart(e) {
        draggedItem = this;
        this.classList.add('opacity-50');
    }

    function handleDragEnd(e) {
        draggedItem.classList.remove('opacity-50');
        draggedItem = null;
    }

    function handleDragOver(e) {
        e.preventDefault();
    }

    function handleDrop(e) {
        e.preventDefault();
        if (!draggedItem) return;

        const itemsContainer = this.querySelector('.items-container');
        const clone = draggedItem.cloneNode(true);
        clone.classList.add('scale-75');
        
        // Thêm nút xóa
        const deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = '❌';
        deleteBtn.className = 'absolute -top-2 -right-2 text-xs';
        deleteBtn.onclick = function() {
            clone.remove();
            updateWeights();
        };
        clone.style.position = 'relative';
        clone.appendChild(deleteBtn);
        
        itemsContainer.appendChild(clone);
        updateWeights();
    }

    function updateWeights() {
        plates.forEach(plate => {
            const items = plate.querySelectorAll('.draggable-item');
            let totalWeight = 0;
            
            items.forEach(item => {
                totalWeight += parseInt(item.dataset.weight);
            });
            
            plate.dataset.weight = totalWeight;
            plate.querySelector('.total-weight').textContent = totalWeight >= 1000 ? 
                (totalWeight / 1000) + 'kg' : totalWeight + 'g';
        });

        checkBalance();
    }

    function checkBalance() {
        const leftWeight = parseInt(plates[0].dataset.weight);
        const rightWeight = parseInt(plates[1].dataset.weight);
        
        // Cập nhật góc nghiêng
        const maxTilt = 20;
        const tiltAngle = Math.min(maxTilt, 
            Math.abs(leftWeight - rightWeight) / 100);
        
        if (leftWeight > rightWeight) {
            plates[0].style.transform = `translateY(${tiltAngle}px)`;
            plates[1].style.transform = `translateY(-${tiltAngle}px)`;
        } else if (rightWeight > leftWeight) {
            plates[0].style.transform = `translateY(-${tiltAngle}px)`;
            plates[1].style.transform = `translateY(${tiltAngle}px)`;
        } else {
            plates[0].style.transform = 'translateY(0)';
            plates[1].style.transform = 'translateY(0)';
        }

        // Hiển thị thông báo
        if (leftWeight === rightWeight && leftWeight > 0) {
            showMessage('Đúng rồi! Hai bên cân bằng nhau! 🎉', 'bg-green-500');
        } else if (leftWeight > 0 && rightWeight > 0) {
            showMessage('Chưa đúng, thử lại!', 'bg-red-500');
        } else {
            messageEl.classList.add('hidden');
        }
    }

    function showMessage(text, className) {
        messageEl.textContent = text;
        messageEl.className = `fixed top-4 right-4 p-4 rounded-lg text-white font-bold ${className}`;
        messageEl.classList.remove('hidden');
        
        setTimeout(() => {
            if (!messageEl.classList.contains('hidden')) {
                messageEl.classList.add('hidden');
            }
        }, 3000);
    }
});
</script>
@endsection 