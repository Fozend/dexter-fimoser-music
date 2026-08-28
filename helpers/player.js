document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.player').forEach(setupPlayer);
});

document.addEventListener('play', (e) => {
    if (!e.target.classList.contains('player-audio')) return;
    document.querySelectorAll('.player-audio').forEach(audio => {
        if (audio !== e.target) audio.pause();
    });
}, true);

function setupPlayer(player) {
    const audio = player.querySelector('.player-audio');
    const playBtn = player.querySelector('.player-play');
    const playIcon = playBtn.querySelector('i');
    const seek = player.querySelector('.player-seek');
    const fill = player.querySelector('.player-progress-fill');
    const buffered = player.querySelector('.player-progress-buffered');
    const currentEl = player.querySelector('.player-time-current');
    const durationEl = player.querySelector('.player-time-duration');
    const volumeBtn = player.querySelector('.player-volume-btn');
    const volumeSlider = player.querySelector('.player-volume-slider');
    const speedSelect = player.querySelector('.player-speed');

    function formatTime(sec) {
        if (!isFinite(sec)) return '0:00';
        const m = Math.floor(sec / 60);
        const s = Math.floor(sec % 60).toString().padStart(2, '0');
        return `${m}:${s}`;
    }

    playBtn.addEventListener('click', () => {
        audio.paused ? audio.play() : audio.pause();
    });

    audio.addEventListener('play', () => {
        playIcon.classList.replace('fa-play', 'fa-pause');
    });

    audio.addEventListener('pause', () => {
        playIcon.classList.replace('fa-pause', 'fa-play');
    });

    audio.addEventListener('loadedmetadata', () => {
        durationEl.textContent = formatTime(audio.duration);
        seek.max = audio.duration;
    });

    audio.addEventListener('timeupdate', () => {
        currentEl.textContent = formatTime(audio.currentTime);
        seek.value = audio.currentTime;
        fill.style.width = ((audio.currentTime / audio.duration) * 100 || 0) + '%';
    });

    audio.addEventListener('progress', () => {
        if (audio.buffered.length) {
            const end = audio.buffered.end(audio.buffered.length - 1);
            buffered.style.width = ((end / audio.duration) * 100 || 0) + '%';
        }
    });

    seek.addEventListener('input', () => {
        audio.currentTime = seek.value;
    });

    volumeSlider.addEventListener('input', () => {
        audio.volume = volumeSlider.value;
        audio.muted = false;
        updateVolumeIcon();
    });

    volumeBtn.addEventListener('click', () => {
        audio.muted = !audio.muted;
        updateVolumeIcon();
    });

    function updateVolumeIcon() {
        const icon = volumeBtn.querySelector('i');
        icon.className = (audio.muted || audio.volume === 0)
            ? 'fa-solid fa-volume-xmark'
            : (audio.volume < 0.5 ? 'fa-solid fa-volume-low' : 'fa-solid fa-volume-high');
    }

    speedSelect.addEventListener('change', () => {
        audio.playbackRate = parseFloat(speedSelect.value);
    });
}