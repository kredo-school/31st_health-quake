@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH QUAKE - Habit Rewards</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #E0F7FA;
        }
        .modal {
            transition: opacity 0.3s ease;
        }
        .reward-card {
            transition: transform 0.3s ease;
        }
        .reward-card:hover {
            transform: translateY(-5px);
        }
        .image-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        /* モーダルを強制的に表示するクラス */
        .modal-visible {
            display: flex !important;
        }
    </style>
</head>
<body class="min-h-screen pb-10">

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold mb-2">Set yourself rewards</h1>
            <p class="text-gray-600">You get one of three rewards at random when you reach level 5.</p>
            <!-- ADD REWARDS Button -->
            <button onclick="showAddRewardsModal()" id="addHabitsBtn" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition-all">
                ADD REWARDS
            </button>
        </div>

        <!-- My Rewards Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-center">My rewards</h2>
            <div id="rewardsContainer" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Rewards will be added here via JavaScript -->
                <div class="flex justify-center items-center text-gray-400 col-span-3 py-10">
                    <p>No rewards added yet. Click "ADD REWARDS" to set your rewards.</p>
                </div>
            </div>
        </div>

        <!-- Modal for Adding/Editing Rewards -->
        <div id="rewardsModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
                <div class="bg-red-400 text-white py-4 px-6 rounded-t-lg">
                    <h3 class="text-xl font-bold" id="modalTitle">Set your Rewards</h3>
                </div>
                <div class="p-6">
                    <form id="rewardForm">
                        <input type="hidden" id="editingId" value="">
                        <div class="mb-4">
                            <label for="rewardName" class="block text-gray-700 mb-2">Reward name</label>
                            <input type="text" id="rewardName" placeholder="e.g. Eat favorite food, Watch favorite anime" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="mb-4">
                            <label for="rewardLevel" class="block text-gray-700 mb-2">Level</label>
                            <select id="rewardLevel" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="1">Level 1</option>
                                <option value="2">Level 2</option>
                                <option value="3">Level 3</option>
                                <option value="4">Level 4</option>
                                <option value="5" selected>Level 5</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 mb-2">Let's make motivation image!</label>
                            <div class="border border-gray-300 rounded-md p-3">
                                <div id="previewContainer" class="mb-3 hidden">
                                    <img id="imagePreview" class="image-preview mb-2" src="" alt="Preview">
                                </div>
                                <input type="file" id="rewardImage" accept="image/*" class="w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" onclick="hideModal()" id="cancelBtn" class="px-4 py-2 text-gray-600 mr-2 hover:text-gray-800">Cancel</button>
                            <button type="button" onclick="saveReward()" id="saveBtn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- 直接インラインスクリプト - 確実に実行されるようにする -->
    <script>
        // グローバル変数
        var rewards = [];

        // ページ読み込み完了時に表示する最初のログ
        console.log('ページが読み込まれました');

        // モーダルを表示する関数 - ボタンから直接呼び出し
        function showAddRewardsModal() {
            console.log('ADD REWARDSボタンがクリックされました');

            var rewardsModal = document.getElementById('rewardsModal');
            if (rewardsModal) {
                document.getElementById('rewardForm').reset();
                document.getElementById('editingId').value = '';
                var previewContainer = document.getElementById('previewContainer');
                if (previewContainer) previewContainer.classList.add('hidden');

                var modalTitle = document.getElementById('modalTitle');
                if (modalTitle) modalTitle.textContent = 'Set your Rewards';

                // モーダル表示
                rewardsModal.classList.remove('hidden');
                rewardsModal.style.display = 'flex';
                console.log('モーダルを表示しました');
            } else {
                console.error('rewardsModalが見つかりません');
            }
        }

        // モーダルを非表示にする関数
        function hideModal() {
            console.log('モーダルを非表示にします');
            var rewardsModal = document.getElementById('rewardsModal');
            if (rewardsModal) {
                rewardsModal.classList.add('hidden');
                rewardsModal.style.display = 'none';
            }
        }

        // 報酬を保存する関数
        function saveReward() {
            console.log('保存ボタンがクリックされました');
            var rewardName = document.getElementById('rewardName').value;
            var rewardLevel = document.getElementById('rewardLevel').value;
            var editId = document.getElementById('editingId').value;

            // 入力チェック
            if (!rewardName.trim()) {
                alert('Please enter a reward name');
                return;
            }

            // 画像処理
            var imageSrc = '';
            var rewardImage = document.getElementById('rewardImage');
            var imagePreview = document.getElementById('imagePreview');

            if (rewardImage.files && rewardImage.files[0]) {
                imageSrc = imagePreview.src;
            } else {
                // サンプル画像を使用
                var sampleImages = [
                    'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38',
                    'https://images.unsplash.com/photo-1518791841217-8f162f1e1131',
                    'https://images.unsplash.com/photo-1565958011703-44f9829ba187'
                ];
                imageSrc = sampleImages[Math.floor(Math.random() * sampleImages.length)];
            }

            if (editId) {
                // 既存の報酬を編集
                var index = rewards.findIndex(r => r.id === editId);
                if (index !== -1) {
                    rewards[index] = {
                        ...rewards[index],
                        name: rewardName,
                        level: rewardLevel,
                        image: imageSrc
                    };
                }
            } else {
                // 新しい報酬を追加
                var newReward = {
                    id: 'reward_' + Date.now(),
                    name: rewardName,
                    level: rewardLevel,
                    image: imageSrc
                };
                rewards.push(newReward);
            }

            // 表示を更新
            renderRewards();

            // モーダルを閉じる
            hideModal();
        }

        // 報酬一覧を表示する関数
        function renderRewards() {
            console.log('報酬一覧を更新します:', rewards.length);
            var rewardsContainer = document.getElementById('rewardsContainer');

            if (rewards.length === 0) {
                rewardsContainer.innerHTML = `
                    <div class="flex justify-center items-center text-gray-400 col-span-3 py-10">
                        <p>No rewards added yet. Click "ADD REWARDS" to set your rewards.</p>
                    </div>
                `;
                return;
            }

            rewardsContainer.innerHTML = '';
            rewards.forEach(reward => {
                var card = document.createElement('div');
                card.className = 'reward-card bg-white rounded-lg shadow-md overflow-hidden';
                card.innerHTML = `
                    <div class="relative h-48 overflow-hidden">
                        <img src="${reward.image}" alt="${reward.name}" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                            Level ${reward.level}
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2">${reward.name}</h3>
                        <div class="flex justify-between mt-3">
                            <button type="button" onclick="editReward('${reward.id}')" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <button type="button" onclick="deleteReward('${reward.id}')" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash-alt mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                `;
                rewardsContainer.appendChild(card);
            });
        }

        // 報酬を編集する関数
        function editReward(id) {
            console.log('編集ボタンがクリックされました:', id);
            var reward = rewards.find(r => r.id === id);
            if (reward) {
                document.getElementById('rewardName').value = reward.name;
                document.getElementById('rewardLevel').value = reward.level;
                document.getElementById('editingId').value = reward.id;

                var imagePreview = document.getElementById('imagePreview');
                var previewContainer = document.getElementById('previewContainer');

                if (reward.image) {
                    imagePreview.src = reward.image;
                    previewContainer.classList.remove('hidden');
                } else {
                    previewContainer.classList.add('hidden');
                }

                document.getElementById('modalTitle').textContent = 'Edit your Reward';

                // モーダル表示
                var rewardsModal = document.getElementById('rewardsModal');
                rewardsModal.classList.remove('hidden');
                rewardsModal.style.display = 'flex';
            }
        }

        // 報酬を削除する関数
        function deleteReward(id) {
            console.log('削除ボタンがクリックされました:', id);
            if (confirm('Are you sure you want to delete this reward?')) {
                rewards = rewards.filter(reward => reward.id !== id);
                renderRewards();
            }
        }

        // ファイル選択時のプレビュー表示
        document.getElementById('rewardImage').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('previewContainer').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // モーダル外クリックで閉じる
        document.getElementById('rewardsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal();
            }
        });

        // サンプルデータの読み込み
        window.onload = function() {
            console.log('window.onload イベントが発火しました');

            // サンプルデータを追加
            rewards = [
                {
                    id: 'sample_1',
                    name: 'Eat favorite food',
                    level: 5,
                    image: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38'
                },
                {
                    id: 'sample_2',
                    name: 'Watch favorite anime',
                    level: 5,
                    image: 'https://images.unsplash.com/photo-1518791841217-8f162f1e1131'
                },
                {
                    id: 'sample_3',
                    name: 'Buy something nice',
                    level: 5,
                    image: 'https://images.unsplash.com/photo-1565958011703-44f9829ba187'
                }
            ];

            // 報酬一覧を表示
            renderRewards();
        };

        // 最終チェック - スクリプトの実行確認
        console.log('スクリプトの実行が完了しました');
    </script>
</body>
</html>
@endsection
