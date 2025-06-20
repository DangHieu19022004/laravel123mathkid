@extends('layouts.game')

@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gradient-to-br from-pink-100 to-yellow-100">
        <div class="max-w-2xl mx-auto mt-10 px-8 py-16 rounded-3xl shadow-2xl bg-gradient-to-br from-yellow-100 via-pink-100 to-blue-100 border-4 border-yellow-200">
            <div class="text-center mb-6">
                <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-pink-400 to-blue-400 drop-shadow">Chia Bánh 🎂</h1>
                <div class="flex items-center justify-center gap-2 mt-2">
                    <span class="text-xl font-bold text-pink-500">Cấp độ</span>
                    <span id="level-label" class="text-2xl font-extrabold bg-gradient-to-r from-yellow-400 via-pink-400 to-blue-400 bg-clip-text text-transparent"></span>
                    <span class="text-xl">/5 ⭐</span>
                </div>
            </div>
            <!-- Hướng dẫn chơi -->
            <div class="bg-yellow-50 border-l-4 border-yellow-300 rounded-xl p-4 mb-6 shadow flex flex-col">
                <div class="font-bold text-yellow-700 mb-2 flex items-center gap-2">
                    <span class="text-lg">🎯</span> Hướng dẫn chơi:
                </div>
                <ul class="list-disc list-inside text-gray-700 space-y-1 pl-2 text-left">
                    <li>Mỗi cấp độ sẽ có một chiếc bánh được chia thành nhiều miếng</li>
                    <li>Bạn cần chọn đúng số miếng bánh theo yêu cầu</li>
                    <li>Nhấn "Xác nhận" để kiểm tra kết quả</li>
                    <li>Nhấn "Chơi lại" để bắt đầu lại từ đầu</li>
                </ul>
            </div>
            <div class="flex flex-col items-center mb-8">
                <div id="cake-area" class="flex flex-wrap gap-2 justify-center"></div>
                <div class="mt-4 text-lg font-bold text-blue-700">
                    Chọn đúng <span id="numerator-label"></span> miếng bánh!
                </div>
            </div>
            <div id="message" class="hidden text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4"></div>
            <div class="flex flex-row gap-4 justify-center items-center mt-2">
                <button id="submit-btn" class="px-8 py-3 rounded-full bg-gradient-to-r from-green-400 to-blue-400 text-white font-bold text-xl shadow-lg hover:from-green-500 hover:to-blue-500 transition">Xác nhận</button>
                <button id="reset-btn" class="px-8 py-3 rounded-full bg-gradient-to-r from-pink-400 to-yellow-300 text-white font-bold text-xl shadow-lg hover:from-pink-500 hover:to-yellow-400 transition">Chơi lại</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let questions = @json($questions);
        let currentLevel = 1;
        let selectedPieces = [];

        function renderCake() {
            const q = questions[currentLevel - 1];
            document.getElementById('level-label').textContent = currentLevel;
            document.getElementById('numerator-label').textContent = q.numerator;
            selectedPieces = [];
            const cakeArea = document.getElementById('cake-area');
            cakeArea.innerHTML = '';
            for (let i = 0; i < q.denominator; i++) {
                const piece = document.createElement('button');
                piece.type = 'button';
                piece.className = 'w-16 h-16 rounded-full border-2 border-yellow-400 bg-transparent hover:bg-yellow-100 transition focus:outline-none flex items-center justify-center';
                piece.innerHTML = `
                    <svg width="48" height="48" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                        <path d="M90.595742 591.482946l597.480328-454.389857S933.474816 275.667884 933.474816 462.01006L90.595742 591.482946z" fill="#EACC53" />
                        <path d="M90.595742 591.482946V941.941707L933.474816 812.398264V461.939503z" fill="#F5AD1A" />
                        <path d="M90.595742 791.583821v97.298698L933.474816 759.409633v-97.369255zM468.642458 268.894371s-33.79701 127.426721 179.568663 98.215944c78.318749-12.276993 225.642665-16.863226 202.640943-98.215944-12.276993-29.140219-37.395439-53.129746-43.745608-55.458141 6.350169-12.065321 24.765658-45.509543-17.85103-64.489493-24.201199-8.043547-48.8963-11.500861-63.925033-14.393716-15.522635-6.914628-31.680287-30.48081-12.62978-51.789154-21.308344-3.457314-85.16282 2.892855-122.628815 70.204644-12.62978-1.128919-51.224695-2.328395-61.032178 21.872804-7.479088 21.308344-2.892855 37.959898 2.892854 48.33184-19.544408 3.598429-54.046992 21.167229-63.290016 45.721216z" fill="#F5ECDA" />
                        <path d="M667.049955 236.50851m-67.452904 0a67.452904 67.452904 0 1 0 134.905809 0 67.452904 67.452904 0 1 0-134.905809 0Z" fill="#5B2B20" />
                        <path d="M239.330807 519.161579m-17.85103 0a17.85103 17.85103 0 1 0 35.70206 0 17.85103 17.85103 0 1 0-35.70206 0Z" fill="#774621" />
                        <path d="M286.251499 479.790533m-17.85103 0a17.85103 17.85103 0 1 0 35.70206 0 17.85103 17.85103 0 1 0-35.70206 0Z" fill="#774621" />
                        <path d="M494.184249 483.459519m-17.851031 0a17.85103 17.85103 0 1 0 35.702061 0 17.85103 17.85103 0 1 0-35.702061 0Z" fill="#774621" />
                    </svg>
                `;
                piece.onclick = function () {
                    if (selectedPieces.includes(i)) {
                        selectedPieces = selectedPieces.filter(idx => idx !== i);
                        piece.classList.remove('ring-4', 'ring-pink-400', 'bg-pink-200');
                    } else if (selectedPieces.length < q.numerator) {
                        selectedPieces.push(i);
                        piece.classList.add('ring-4', 'ring-pink-400', 'bg-pink-200');
                    }
                };
                cakeArea.appendChild(piece);
            }
            document.getElementById('message').className = 'hidden text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4';
            document.getElementById('message').textContent = '';
        }

        function checkCakeAnswer() {
            const q = questions[currentLevel - 1];
            const messageDiv = document.getElementById('message');
            if (selectedPieces.length === q.numerator) {
                messageDiv.className = 'block text-green-700 bg-green-100 border-2 border-green-300 text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4 animate-fadein shadow-lg';
                messageDiv.textContent = '🎉 Chính xác! Tiếp tục nào!';
                if (currentLevel < questions.length) {
                    setTimeout(() => {
                        currentLevel++;
                        renderCake();
                    }, 2000);
                }
            } else {
                messageDiv.className = 'block text-red-700 bg-red-100 border-2 border-red-300 text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4 animate-fadein shadow-lg';
                messageDiv.textContent = '⚠️ Chưa đúng số miếng bánh, hãy thử lại!';
                setTimeout(() => {
                    messageDiv.className = 'hidden text-center text-lg font-bold rounded-2xl py-3 px-4 mb-4';
                }, 2000);
            }
        }

        function resetCakeGame() {
            currentLevel = 1;
            renderCake();
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderCake();
            document.getElementById('submit-btn').onclick = checkCakeAnswer;
            document.getElementById('reset-btn').onclick = resetCakeGame;
        });
    </script>
@endpush

@push('styles')
    <style>
        .animate-fadein {
            animation: fadein 0.7s;
        }

        @keyframes fadein {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
@endpush
