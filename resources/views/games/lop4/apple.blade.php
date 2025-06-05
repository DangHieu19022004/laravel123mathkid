@extends('layouts.app')

@section('content')
<div class="game-container">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 mb-4">Chia Táo 🍎</h1>
        <div class="card d-inline-block mb-4">
            <div class="card-body">
                <h2 class="h4 mb-3">Cấp độ {{ $question['level'] }}/5</h2>
                <p class="h5 text-muted">
                    Hãy chia {{ $question['totalApples'] }} quả táo vào {{ $question['groups'] }} nhóm bằng nhau
                </p>
            </div>
        </div>
    </div>

    <!-- Game Area -->
    <div class="row justify-content-center mb-5">
        <!-- Instructions -->
        <div class="col-12 mb-4">
            <div class="alert alert-info">
                <h3 class="h5 mb-3">🎯 Hướng dẫn chơi:</h3>
                <ul class="text-start mb-0">
                    <li>Có tổng cộng {{ $question['totalApples'] }} quả táo</li>
                    <li>Bạn cần chia đều vào {{ $question['groups'] }} nhóm</li>
                    <li>Kéo và thả táo vào từng nhóm</li>
                    <li>Mỗi nhóm phải có số táo bằng nhau</li>
                </ul>
            </div>
        </div>

        <!-- Apple Source -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body text-center" id="apple-source">
                    <!-- Apples will be added here -->
                </div>
            </div>
        </div>

        <!-- Apple Groups -->
        <div class="col-12">
            <div class="row g-4 justify-content-center" id="apple-groups">
                <!-- Groups will be added here -->
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="text-center">
        <button type="button" onclick="checkAnswer()" class="btn btn-game mb-3">
            Kiểm tra
        </button>

        <div id="message" class="alert d-none my-3"></div>

        <form id="resetForm" action="{{ url(route('games.lop4.phanso.apple.reset')) }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none">
                Chơi lại từ đầu
            </button>
        </form>

        <a href="{{ url(route('games.lop4.phanso')) }}" class="btn btn-link text-decoration-none">
            ← Quay lại danh sách
        </a>
    </div>
</div>

@push('scripts')
<script>
const BASE_URL = '{{ url('/') }}';
const CHECK_URL = '{{ url(route('games.lop4.phanso.apple.check')) }}';
const CSRF_TOKEN = '{{ csrf_token() }}';

function checkAnswer() {
    console.log('Checking answer...');
    const groups = document.querySelectorAll('.droppable');
    const groupCounts = Array.from(groups).map(group => group.children.length);
    console.log('Group counts:', groupCounts);
    
    const formData = new FormData();
    formData.append('group_counts', JSON.stringify(groupCounts));
    formData.append('totalApples', {{ $question['totalApples'] }});
    formData.append('groups', {{ $question['groups'] }});
    formData.append('_token', CSRF_TOKEN);
    
    console.log('Sending request to:', CHECK_URL);
    
    fetch(CHECK_URL, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response received:', response);
        return response.json();
    })
    .then(data => {
        console.log('Data:', data);
        const messageDiv = document.getElementById('message');
        messageDiv.classList.remove('d-none');
        
        if (data.correct) {
            messageDiv.className = 'alert alert-success animate-bounce';
            messageDiv.textContent = '🎉 Tuyệt vời! Cùng tiếp tục nào! 🎉';
            
            if (typeof confetti !== 'undefined') {
                confetti({
                    particleCount: 150,
                    spread: 70,
                    origin: { y: 0.6 },
                    colors: ['#ff69b4', '#ff1493', '#ff69b4', '#dda0dd']
                });
            }

            if (data.next_level) {
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            }
        } else {
            messageDiv.className = 'alert alert-warning';
            const applesPerGroup = {{ $question['totalApples'] }} / {{ $question['groups'] }};
            messageDiv.innerHTML = `
                <h4 class="alert-heading">⚠️ Hãy thử lại!</h4>
                <p class="mb-0">Các nhóm chưa có số táo bằng nhau.</p>
                <hr>
                <p class="mb-0">💡 Gợi ý: Mỗi nhóm cần có ${applesPerGroup} quả táo.</p>
                <ul class="mb-0 mt-2">
                    ${groupCounts.map((count, i) => `
                        <li>Nhóm ${i + 1}: ${count} táo ${count === applesPerGroup ? '✅' : '❌'}</li>
                    `).join('')}
                </ul>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const messageDiv = document.getElementById('message');
        messageDiv.classList.remove('d-none');
        messageDiv.className = 'alert alert-danger';
        messageDiv.textContent = 'Có lỗi xảy ra, vui lòng thử lại!';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const totalApples = {{ $question['totalApples'] }};
    const groups = {{ $question['groups'] }};
    
    // Initialize game
    function initGame() {
        // Create apple source
        const source = document.getElementById('apple-source');
        source.innerHTML = '';
        for (let i = 0; i < totalApples; i++) {
            const apple = createApple();
            source.appendChild(apple);
        }
        
        // Create groups
        const groupsContainer = document.getElementById('apple-groups');
        groupsContainer.innerHTML = '';
        for (let i = 0; i < groups; i++) {
            const group = createGroup(i + 1);
            groupsContainer.appendChild(group);
        }
        
        // Initialize drag and drop
        initDragAndDrop();
    }
    
    function createApple() {
        const apple = document.createElement('div');
        apple.className = 'apple draggable';
        apple.draggable = true;
        apple.innerHTML = '🍎';
        return apple;
    }
    
    function createGroup(number) {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        
        const group = document.createElement('div');
        group.className = 'card h-100 apple-group';
        group.innerHTML = `
            <div class="card-header text-center">
                Nhóm ${number}
            </div>
            <div class="card-body droppable" data-group="${number}">
                <!-- Apples will be dropped here -->
            </div>
        `;
        
        col.appendChild(group);
        return col;
    }
    
    function initDragAndDrop() {
        const draggables = document.querySelectorAll('.draggable');
        const droppables = document.querySelectorAll('.droppable');
        
        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
            });
            
            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
            });
        });
        
        droppables.forEach(droppable => {
            droppable.addEventListener('dragover', e => {
                e.preventDefault();
                droppable.classList.add('drag-over');
            });
            
            droppable.addEventListener('dragleave', () => {
                droppable.classList.remove('drag-over');
            });
            
            droppable.addEventListener('drop', e => {
                e.preventDefault();
                droppable.classList.remove('drag-over');
                const apple = document.querySelector('.dragging');
                if (apple) {
                    droppable.appendChild(apple);
                }
            });
        });
    }
    
    initGame();
});
</script>
@endpush

@push('styles')
<style>
.btn-game {
    background: linear-gradient(45deg, #ff69b4, #ff1493);
    color: white;
    border: none;
    padding: 10px 30px;
    border-radius: 25px;
    font-size: 1.2rem;
    transition: transform 0.2s;
}
.btn-game:hover {
    transform: scale(1.05);
    color: white;
}
.animate-bounce {
    animation: bounce 0.5s;
}
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
.apple {
    display: inline-block;
    font-size: 2rem;
    margin: 5px;
    cursor: grab;
    user-select: none;
}
.apple.dragging {
    opacity: 0.5;
    cursor: grabbing;
}
.apple-group {
    min-height: 200px;
    border: 2px dashed #ddd;
    transition: border-color 0.3s;
}
.apple-group .card-header {
    background-color: #f8f9fa;
    font-weight: bold;
}
.droppable {
    padding: 1rem;
    min-height: 150px;
}
.droppable.drag-over {
    background-color: #f8f9fa;
    border-color: #ff69b4;
}
</style>
@endpush
@endsection 