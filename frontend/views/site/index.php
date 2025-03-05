<?php

/** @var yii\web\View $this */

$this->title = 'Luxury Casino Winner Selector';

// Register CSS inline - in a production app, you'd use an asset bundle instead
$this->registerCss('
@import url(\'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Montserrat:wght@300;400;600;700&display=swap\');

body {
    font-family: \'Montserrat\', sans-serif;
    background-color: #000;
    color: #fff;
}

.parallax {
    background-image: url(\'https://cdnjs.cloudflare.com/ajax/libs/placeholder-images/0.6.0/images/abstract.png\');
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
}

.parallax::before {
    content: \'\';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle, rgba(50, 16, 94, 0.8) 0%, rgba(0, 0, 0, 0.95) 100%);
    z-index: 0;
}

.gold-gradient {
    background: linear-gradient(135deg, #f6e27a 0%, #e6b400 50%, #c39738 100%);
}

.name-slot {
    height: 100px;
    line-height: 100px;
    text-align: center;
    font-family: \'Playfair Display\', serif;
    font-size: 3.5rem;
    font-weight: bold;
    color: white;
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    position: relative;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.scroll-container {
    height: 300px;
    /* Exactly 3 slots visible */
    overflow: hidden;
    position: relative;
    border-radius: 0.75rem;
    background: linear-gradient(180deg, rgba(20, 20, 40, 0.9) 0%, rgba(0, 0, 0, 0.98) 48%, rgba(20, 20, 40, 0.9) 100%);
    box-shadow: 0 0 25px rgba(120, 60, 220, 0.3),
        inset 0 0 15px rgba(120, 60, 220, 0.2),
        0 0 5px rgba(255, 215, 0, 0.5);
    border: 1px solid rgba(255, 215, 0, 0.3);
}

.scroll-container::before,
.scroll-container::after {
    content: \'\';
    position: absolute;
    left: 0;
    right: 0;
    height: 80px;
    z-index: 10;
    pointer-events: none;
}

.scroll-container::before {
    top: 0;
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0) 100%);
}

.scroll-container::after {
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0) 100%);
}

.scroll-content {
    display: flex;
    flex-direction: column;
    will-change: transform;
}

.center-indicator {
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    height: 100px;
    /* Match slot height */
    margin-top: -50px;
    /* Half of slot height */
    border-top: 2px solid rgba(255, 215, 0, 0.7);
    border-bottom: 2px solid rgba(255, 215, 0, 0.7);
    pointer-events: none;
    z-index: 5;
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.6),
        0 0 20px rgba(255, 215, 0, 0.3),
        inset 0 0 10px rgba(255, 215, 0, 0.3);
}

.center-highlight {
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    height: 100px;
    margin-top: -50px;
    background: linear-gradient(to right,
            transparent 0%,
            rgba(255, 215, 0, 0.1) 20%,
            rgba(255, 215, 0, 0.3) 50%,
            rgba(255, 215, 0, 0.1) 80%,
            transparent 100%);
    pointer-events: none;
    z-index: 4;
    border-radius: 10px;
}

/* Winner effects */
@keyframes winnerPulse {
    0% {
        transform: scale(1);
        filter: brightness(1);
        text-shadow: 0 0 10px #fff, 0 0 20px #fde047;
    }

    50% {
        transform: scale(1.15);
        filter: brightness(1.5);
        text-shadow: 0 0 20px #fff, 0 0 30px #fde047, 0 0 40px #fde047, 0 0 50px #fde047;
    }

    100% {
        transform: scale(1);
        filter: brightness(1);
        text-shadow: 0 0 10px #fff, 0 0 20px #fde047;
    }
}

.winner-pulse {
    animation: winnerPulse 1.5s infinite ease-in-out;
    background: linear-gradient(90deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 215, 0, 0.3) 50%, rgba(255, 215, 0, 0.1) 100%);
    color: #fffaf0;
    text-shadow: 0 0 10px #fff, 0 0 20px #fde047;
}

/* Enhanced confetti effect */
@keyframes confetti-fall {
    0% {
        transform: translateY(-100px) rotate(0deg) scale(0.7);
        opacity: 1;
    }

    50% {
        transform: translateY(calc(50vh - 100px)) rotate(180deg) scale(1);
        opacity: 1;
    }

    100% {
        transform: translateY(calc(100vh - 100px)) rotate(360deg) scale(0.7);
        opacity: 0;
    }
}

.confetti {
    position: fixed;
    width: 15px;
    height: 15px;
    opacity: 0;
    animation: confetti-fall 5s ease-out forwards;
    z-index: 100;
    border-radius: 2px;
    mix-blend-mode: screen;
}

/* Wheel appearance */
.name-slot:nth-child(even) {
    background-color: rgba(60, 25, 100, 0.1);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.name-slot:nth-child(odd) {
    background-color: rgba(0, 0, 0, 0.2);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

/* Winner display animations */
@keyframes goldShine {
    0% {
        background-position: -100% 0;
    }

    100% {
        background-position: 200% 0;
    }
}

@keyframes bounceIn {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }

    50% {
        transform: scale(1.05);
        opacity: 1;
    }

    70% {
        transform: scale(0.9);
    }

    100% {
        transform: scale(1);
    }
}

.animate__bounceIn {
    animation: bounceIn 0.75s;
}

#winnerDisplay {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.9) 0%, rgba(40, 10, 60, 0.8) 100%);
    border-radius: 0.75rem;
    border: 1px solid rgba(255, 215, 0, 0.3);
    box-shadow: 0 0 20px rgba(120, 60, 220, 0.2);
    padding: 1rem;
    position: relative;
    /* Note: winnerDisplay is hidden by default */
    display: none;
}

#winnerDisplay::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 300%;
    height: 100%;
    background: linear-gradient(90deg,
            transparent 20%,
            rgba(255, 255, 255, 0.2) 40%,
            rgba(255, 255, 255, 0.5) 50%,
            rgba(255, 255, 255, 0.2) 60%,
            transparent 80%);
    animation: goldShine 3s infinite linear;
}

.glow-text {
    color: #ffd700;
    text-shadow: 0 0 5px rgba(255, 215, 0, 0.5),
        0 0 10px rgba(255, 215, 0, 0.3);
}

/* Improved form and buttons */
input:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.5);
}

.gold-button {
    background: linear-gradient(135deg, #f6e27a 0%, #e6b400 50%, #c39738 100%);
    color: #000;
    font-weight: bold;
    border: none;
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.3),
        0 5px 15px rgba(0, 0, 0, 0.3);
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.5);
    transition: all 0.3s;
}

.gold-button:hover {
    background: linear-gradient(135deg, #f9eb8f 0%, #f0c52e 50%, #d6aa46 100%);
    box-shadow: 0 0 15px rgba(255, 215, 0, 0.5),
        0 5px 10px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

.gold-button:active {
    transform: translateY(1px);
    box-shadow: 0 0 5px rgba(255, 215, 0, 0.3),
        0 2px 5px rgba(0, 0, 0, 0.3);
}

.start-button {
    background: linear-gradient(135deg, #4c2a9c 0%, #7742ff 50%, #4c2a9c 100%);
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 0 15px rgba(120, 60, 220, 0.4),
        0 5px 15px rgba(0, 0, 0, 0.3);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    transition: all 0.3s;
}

.start-button:hover {
    background: linear-gradient(135deg, #5a32b8 0%, #8b5bff 50%, #5a32b8 100%);
    box-shadow: 0 0 20px rgba(120, 60, 220, 0.6),
        0 5px 10px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

.start-button:active {
    transform: translateY(1px);
    box-shadow: 0 0 10px rgba(120, 60, 220, 0.4),
        0 2px 5px rgba(0, 0, 0, 0.3);
}

/* Player list */
.player-list-container {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.9) 0%, rgba(40, 10, 60, 0.8) 100%);
    border-radius: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

/* Game machine container */
.game-machine {
    background: linear-gradient(135deg, #1c0c35 0%, #2d114a 100%);
    border-radius: 1rem;
    border: 4px solid rgba(255, 215, 0, 0.5);
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.8),
        0 0 50px rgba(120, 60, 220, 0.3),
        inset 0 0 20px rgba(0, 0, 0, 0.5);
    position: relative;
    overflow: hidden;
}

.game-machine::before {
    content: \'\';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to bottom, rgba(120, 60, 220, 0.2) 0%, transparent 100%);
    pointer-events: none;
    z-index: 1;
}

/* Flashing lights effect */
@keyframes flashingLight {
    0% {
        opacity: 0.4;
    }

    50% {
        opacity: 1;
    }

    100% {
        opacity: 0.4;
    }
}

.light {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #ffd700;
    box-shadow: 0 0 10px #ffd700, 0 0 20px #ffd700;
    animation: flashingLight 0.5s infinite alternate;
}

/* Lever animation */
@keyframes leverPull {
    0% {
        transform: rotate(0deg);
    }

    50% {
        transform: rotate(30deg);
    }

    100% {
        transform: rotate(0deg);
    }
}

.machine-decoration::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 50%;
    width: 80%;
    height: 20px;
    transform: translateX(-50%);
    background: linear-gradient(90deg,
            rgba(255, 215, 0, 0.5) 0%,
            rgba(255, 215, 0, 0.8) 50%,
            rgba(255, 215, 0, 0.5) 100%);
    border-radius: 50%;
    filter: blur(10px);
}
');

// Register Tailwind CSS from CDN
$this->registerJsFile('https://cdn.tailwindcss.com', ['position' => \yii\web\View::POS_HEAD]);
?>
<div class="bg-black min-h-screen flex items-center justify-center parallax">
    <div class="w-full max-w-4xl mx-auto p-6 relative z-10">
        <!-- Player List Section -->
        <div class="mb-8 player-list-container p-5 rounded-lg">
            <h2 class="text-white font-bold mb-3 text-xl flex items-center">
                <span class="mr-2">♦</span> Current Players <span class="ml-2">♦</span>
            </h2>
            <div id="playerList" class="text-gray-300 max-h-40 overflow-y-auto"></div>
        </div>

        <!-- Player Form Section -->
        <div class="mb-8">
            <form id="addPlayerForm" class="flex gap-2">
                <input type="text" id="playerName" class="flex-1 px-4 py-3 rounded-lg bg-gray-900 text-white border border-purple-900 focus:outline-none" placeholder="Enter player name">
                <button type="submit" class="px-6 py-3 rounded-lg gold-button">Add Player</button>
            </form>
        </div>

        <!-- Logo Section -->
        <div class="flex justify-center mb-8">
            <img src="<?= Yii::getAlias('@web') ?>/images/33.png" alt="Logo" class="h-48">
        </div>

        <!-- Game Machine -->
        <div class="game-machine h-[600px] w-full max-w-2xl mx-auto p-6 relative">
            <!-- Decoration lights -->
            <div class="absolute top-3 left-3 light" style="animation-delay: 0.1s"></div>
            <div class="absolute top-3 right-3 light" style="animation-delay: 0.3s"></div>
            <div class="absolute bottom-3 left-3 light" style="animation-delay: 0.2s"></div>
            <div class="absolute bottom-3 right-3 light" style="animation-delay: 0.4s"></div>

            <!-- Scroll Container -->
            <div class="scroll-container relative">
                <div class="center-indicator"></div>
                <div class="center-highlight"></div>
                <div id="nameScroller" class="scroll-content"></div>
            </div>

            <!-- Winner Display Area -->
            <div id="winnerDisplay" class="mt-6 text-center">
                <h2 class="text-3xl font-bold glow-text" id="winnerTitle">WINNER!</h2>
                <p id="winnerName" class="text-2xl text-yellow-200 my-2 font-semibold"></p>
                <p id="winnerPrize" class="text-lg text-yellow-400"></p>
            </div>
        </div>

        <!-- Start Button (always displays "Click to Spin") -->
        <div id="audio" class="flex justify-center items-center py-8">
            <button id="startButton" class="px-8 py-4 w-full max-w-2xl rounded-lg start-button text-lg">
                SPIN TO WIN
            </button>
        </div>


        <div class="mt-10 mb-10">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-yellow-300 font-['Playfair_Display']">
                    Past Winners
                </h2>
                <a href="#" class="px-4 py-2 rounded-lg gold-button text-sm">
                    View All Winners
                </a>
            </div>
            <!-- Horizontal card layout with spacing between each card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Winner 1 Card -->
            <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                <div class="h-48">
                <img src="<?= Yii::getAlias('@web') ?>/images/winner1.jpg" alt="Winner 1" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                </div>
                <div class="p-6 flex-grow">
                <h3 class="text-yellow-300 text-xl font-bold mb-2 font-['Playfair_Display']">Michael Johnson</h3>
                <div class="text-yellow-200 text-sm mb-3">April 15, 2023</div>
                <p class="text-gray-300">Won the Grand Prize jackpot worth $8,500 during our Spring Special Event.</p>
                </div>
            </div>
            <!-- Winner 2 Card -->
            <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                <div class="h-48">
                <img src="<?= Yii::getAlias('@web') ?>/images/winner2.jpg" alt="Winner 2" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                </div>
                <div class="p-6 flex-grow">
                <h3 class="text-yellow-300 text-xl font-bold mb-2 font-['Playfair_Display']">Sarah Williams</h3>
                <div class="text-yellow-200 text-sm mb-3">June 22, 2023</div>
                <p class="text-gray-300">Won the VIP Bonus package including a luxury weekend getaway and $5,000 cash.</p>
                </div>
            </div>
            <!-- Winner 3 Card -->
            <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                <div class="h-48">
                <img src="<?= Yii::getAlias('@web') ?>/images/winner3.jpg" alt="Winner 3" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                </div>
                <div class="p-6 flex-grow">
                <h3 class="text-yellow-300 text-xl font-bold mb-2 font-['Playfair_Display']">David Thompson</h3>
                <div class="text-yellow-200 text-sm mb-3">August 7, 2023</div>
                <p class="text-gray-300">Won the Weekly Draw prize of $3,200 plus exclusive casino bonus credits.</p>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Audio Player -->
<audio id="audioPlayer" src="<?= Yii::getAlias('@web') ?>/audio/m7.mp3" preload="auto"></audio>
</div>
</div>

<?php
$this->registerJs('
// Audio play/pause handler
document.getElementById("startButton").addEventListener("click", function() {
    var audio = document.getElementById("audioPlayer");
    if (audio.paused) {
        audio.play();
    } else {
        audio.pause();
        audio.currentTime = 0; // Reset to start if needed
    }
});

// Enhanced JavaScript for the casino name scroll with wheel-style animation
let players = [];
let animationId = null;
let isScrolling = false;
let position = 0;
let currentSpeed = 0;
let phase = "stopped";

// Animation settings
const MIN_SPEED = 0.2; // Starting speed
const MAX_SPEED = 25; // Maximum speed
const ACCELERATION = 0.4; // How quickly it speeds up
const INITIAL_DECELERATION = 0.05; // Slow deceleration phase
const FINAL_DECELERATION = 0.3; // Faster deceleration for "clicking" effect
const TOTAL_DURATION = 8000; // Total animation time (ms)
const BOUNCE_AMOUNT = 2; // Bounce effect amplitude
const SLOT_HEIGHT = 100; // Height of each slot (px)
// Define the center offset so that the winning slot is centered.
const CENTER_OFFSET = (300 - SLOT_HEIGHT) / 2; // 100px

// Update the player list display
function updatePlayerList() {
    document.getElementById("playerList").innerHTML =
        players.map(player => `<div class="mb-1">• ${player}</div>`).join("");
}

// Update the name scroller with repeated names for smooth scrolling
function updateNameScroller() {
    const scroller = document.getElementById("nameScroller");
    scroller.innerHTML = "";
    scroller.className = "scroll-content";

    // Create a repeated list of names (repeat enough times for infinite scroll)
    const repeatedNames = [...players, ...players, ...players, ...players, ...players];
    repeatedNames.forEach(name => {
        const div = document.createElement("div");
        div.className = "name-slot";
        div.textContent = name;
        scroller.appendChild(div);
    });

    // Set initial position so that the center slot is chosen
    position = -SLOT_HEIGHT;
    scroller.style.transform = `translateY(${position}px)`;
}

// Add player form handler
document.getElementById("addPlayerForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const nameInput = document.getElementById("playerName");
    const name = nameInput.value.trim();
    if (name) {
        players.push(name);
        nameInput.value = "";
        updatePlayerList();
        updateNameScroller();
    }
});

// Start button handler with wheel-style animation
document.getElementById("startButton").addEventListener("click", () => {
    if (players.length < 2) {
        alert("Add at least 2 players to start");
        return;
    }
    if (isScrolling) return;

    const scroller = document.getElementById("nameScroller");
    // Instead of changing the button text, show "Processing..." in the winnerDisplay area
    document.getElementById("winnerName").textContent = "Processing...";
    document.getElementById("winnerPrize").textContent = "";
    // Ensure the winnerDisplay area is visible
    document.getElementById("winnerDisplay").style.display = "block";

    // Remove any previous winner effects
    document.querySelectorAll(".name-slot").forEach(slot => {
        slot.classList.remove("winner-pulse", "text-yellow-300", "scale-110", "opacity-50");
        slot.style.textShadow = "";
    });

    // Reset animation state
    position = -SLOT_HEIGHT;
    currentSpeed = MIN_SPEED;
    phase = "accelerating";
    isScrolling = true;

    // Define timing phases
    let startTime = Date.now();
    let phaseChangeTime = startTime + (TOTAL_DURATION * 0.25);
    let fastPhaseTime = startTime + (TOTAL_DURATION * 0.5);
    let decelerationTime = startTime + (TOTAL_DURATION * 0.7);
    let finalDecelerationTime = startTime + (TOTAL_DURATION * 0.9);

    let decelerationRate = INITIAL_DECELERATION;
    let bounceFactor = 1.0;

    // Animation function with wheel-like behavior
    function animate() {
        const currentTime = Date.now();

        if (phase === "accelerating" && currentTime >= phaseChangeTime) {
            phase = "fast";
        } else if (phase === "fast" && currentTime >= fastPhaseTime) {
            phase = "slowing";
        } else if (phase === "slowing" && currentTime >= decelerationTime) {
            phase = "decelerating";
        } else if (phase === "decelerating" && currentTime >= finalDecelerationTime) {
            phase = "finalizing";
        }

        if (phase === "accelerating") {
            currentSpeed = Math.min(currentSpeed + ACCELERATION, MAX_SPEED);
        } else if (phase === "fast") {
            currentSpeed = MAX_SPEED * (0.95 + Math.random() * 0.1);
        } else if (phase === "slowing") {
            currentSpeed = Math.max(currentSpeed - (INITIAL_DECELERATION * 0.5), MAX_SPEED * 0.7);
        } else if (phase === "decelerating") {
            decelerationRate = INITIAL_DECELERATION * (1 + ((currentTime - decelerationTime) / (finalDecelerationTime - decelerationTime)));
            currentSpeed = Math.max(currentSpeed - decelerationRate, MIN_SPEED * 4);
        } else if (phase === "finalizing") {
            currentSpeed = Math.max(currentSpeed - FINAL_DECELERATION, 0);
            if (currentSpeed <= 0.2) {
                alignToClosestSlot();
                finalizeWinner();
                return;
            }
        }

        position -= currentSpeed * bounceFactor;
        const totalHeight = players.length * SLOT_HEIGHT;
        if (Math.abs(position) > totalHeight) {
            position = position % totalHeight;
        }
        scroller.style.transform = `translateY(${position}px)`;
        animationId = requestAnimationFrame(animate);
    }

    animationId = requestAnimationFrame(animate);
});

// Align to the closest slot so that its center matches the container center.
function alignToClosestSlot() {
    const scroller = document.getElementById("nameScroller");
    const targetIndex = Math.round((Math.abs(position) + CENTER_OFFSET) / SLOT_HEIGHT);
    const targetPosition = -(targetIndex * SLOT_HEIGHT - CENTER_OFFSET);

    let bounceOffset = BOUNCE_AMOUNT;
    let bounceStep = 0;

    function applyBounce() {
        if (bounceStep < 10) {
            bounceOffset = BOUNCE_AMOUNT * Math.sin((bounceStep / 10) * Math.PI);
            position = targetPosition - bounceOffset;
            scroller.style.transform = `translateY(${position}px)`;
            bounceStep++;
            requestAnimationFrame(applyBounce);
        } else {
            position = targetPosition;
            scroller.style.transform = `translateY(${position}px)`;
        }
    }

    applyBounce();
}

// Determine and display the winner ensuring it is centered.
function finalizeWinner() {
    isScrolling = false;
    cancelAnimationFrame(animationId);

    const adjustedPosition = Math.abs(position) + CENTER_OFFSET;
    const visibleIndex = Math.round(adjustedPosition / SLOT_HEIGHT) % players.length;
    const winner = players[visibleIndex];

    const nameSlots = document.querySelectorAll(".name-slot");
    nameSlots.forEach((slot, index) => {
        if (index % players.length === visibleIndex) {
            slot.classList.add("text-yellow-300", "scale-110", "transition-all", "duration-500", "winner-pulse");
            slot.style.textShadow = "0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fde047, 0 0 40px #fde047, 0 0 50px #fde047";
        } else {
            slot.classList.add("opacity-50");
        }
    });

    createConfetti();

    document.getElementById("winnerName").textContent = winner;
    document.getElementById("winnerPrize").textContent = "Congratulations!";
    const winnerDisplay = document.getElementById("winnerDisplay");
    winnerDisplay.classList.remove("animate__bounceIn");
    winnerDisplay.classList.add("animate__bounceIn");

    // Note: the start button text remains unchanged ("Click to Spin")
    document.getElementById("startButton").disabled = false;
}

// Create a confetti effect when a winner is chosen.
function createConfetti() {
    const colors = ["#FFC700", "#FF0000", "#2E3191", "#41C0F0", "#FF5CE4", "#76EE00"];
    const container = document.body;

    for (let i = 0; i < 100; i++) {
        const confetti = document.createElement("div");
        confetti.className = "confetti";
        confetti.style.left = Math.random() * 100 + "vw";
        confetti.style.animationDuration = (Math.random() * 3 + 2) + "s";
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
        container.appendChild(confetti);
        setTimeout(() => {
            confetti.remove();
        }, 5000);
    }
}
');
?>