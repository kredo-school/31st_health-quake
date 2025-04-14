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
    </style>
</head>
<body class="min-h-screen pb-10">
 
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold mb-2">Set yourself rewards</h1>
            <p class="text-gray-600">You get one of three rewards at random when you reach level 5.</p>
            <!-- ADD HABITS Button -->
            <button id="addHabitsBtn" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition-all">
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
        <div id="rewardsModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
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
                            <button type="button" id="cancelBtn" class="px-4 py-2 text-gray-600 mr-2 hover:text-gray-800">Cancel</button>
                            <button type="submit" id="saveBtn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-md">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const addHabitsBtn = document.getElementById('addHabitsBtn');
            const rewardsModal = document.getElementById('rewardsModal');
            const rewardsContainer = document.getElementById('rewardsContainer');
            const rewardForm = document.getElementById('rewardForm');
            const cancelBtn = document.getElementById('cancelBtn');
            const rewardImage = document.getElementById('rewardImage');
            const imagePreview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('previewContainer');
            const editingId = document.getElementById('editingId');
            const modalTitle = document.getElementById('modalTitle');


// Sample reward images
            const sampleImages = [
                'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38',
                'https://images.unsplash.com/photo-1518791841217-8f162f1e1131',
                'https://images.unsplash.com/photo-1565958011703-44f9829ba187'
            ];
            // Rewards store
            let rewards = [];
            // Show modal
            addHabitsBtn.addEventListener('click', function() {
                if (rewards.length >= 3) {
                    alert('You can only have a maximum of 3 rewards. Please delete some to add more.');
                    return;
                }
                // Reset form for adding new reward
                rewardForm.reset();
                editingId.value = '';
                previewContainer.classList.add('hidden');
                modalTitle.textContent = 'Set your Rewards';
                rewardsModal.classList.remove('hidden');
            });
            // Close modal
            cancelBtn.addEventListener('click', function() {
                rewardsModal.classList.add('hidden');
            });
            // Image preview
            rewardImage.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
            // Save reward
            rewardForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const rewardName = document.getElementById('rewardName').value;
                const rewardLevel = document.getElementById('rewardLevel').value;
                const editId = editingId.value;
                // Validation
                if (!rewardName.trim()) {
                    alert('Please enter a reward name');
                    return;
                }
                // Get image from file or use sample
                let imageSrc = '';
                if (rewardImage.files && rewardImage.files[0]) {
                    imageSrc = imagePreview.src;
                } else {
                    // Use random sample image if none uploaded
                    imageSrc = sampleImages[Math.floor(Math.random() * sampleImages.length)];
                }
                if (editId) {
                    // Edit existing reward
                    const index = rewards.findIndex(r => r.id === editId);
                    if (index !== -1) {
                        rewards[index] = {
                            ...rewards[index],
                            name: rewardName,
                            level: rewardLevel,
                            image: imageSrc
                        };
                    }
                } else {
                    // Add new reward
                    const newReward = {
                        id: 'reward_' + Date.now(),
                        name: rewardName,
                        level: rewardLevel,
                        image: imageSrc
                    };
                    rewards.push(newReward);
                }
                // Update display
                renderRewards();
                // Close modal
                rewardsModal.classList.add('hidden');
            });
            // Delete reward
            function deleteReward(id) {
                if (confirm('Are you sure you want to delete this reward?')) {
                    rewards = rewards.filter(reward => reward.id !== id);
                    renderRewards();
                }
            }
            // Edit reward
            function editReward(id) {
                const reward = rewards.find(r => r.id === id);
                if (reward) {
                    document.getElementById('rewardName').value = reward.name;
                    document.getElementById('rewardLevel').value = reward.level;
                    editingId.value = reward.id;
                    if (reward.image) {
                        imagePreview.src = reward.image;
                        previewContainer.classList.remove('hidden');
                    } else {
                        previewContainer.classList.add('hidden');
                    }
                    modalTitle.textContent = 'Edit your Reward';
                    rewardsModal.classList.remove('hidden');
                }
            }
            // Render rewards
            function renderRewards() {
                if (rewards.length === 0) {
                    rewardsContainer.innerHTML = `
                        <div class="flex justify-center items-center text-gray-400 col-span-3 py-10">
                            <p>No rewards added yet. Click "ADD HABITS" to set your rewards.</p>
                        </div>
                    `;
                    return;
                }
                rewardsContainer.innerHTML = '';
                rewards.forEach(reward => {
                    const card = document.createElement('div');
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
                                <button onclick="editReward('${reward.id}')" class="text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <button onclick="deleteReward('${reward.id}')" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </div>
                        </div>
                    `;
                    rewardsContainer.appendChild(card);
                });
            }
            // Make functions globally available
            window.deleteReward = deleteReward;
            window.editReward = editReward;
            // Add sample rewards
            if (rewards.length === 0) {
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
                renderRewards();
            }
            // Click outside modal to close
            window.addEventListener('click', function(e) {
                if (e.target === rewardsModal) {
                    rewardsModal.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
@endsection