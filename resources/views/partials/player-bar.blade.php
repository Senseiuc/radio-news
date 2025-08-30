<?php
/**
 * Site-wide audio player bar. Appears fixed at bottom when a stream URL is configured.
 * Uses Alpine.js for simple state and HTML5 Audio.
 * - Reads initial config from $siteSettings (radio_stream_url, radio_now_playing, radio_schedule)
 * - Persists play state in sessionStorage ('radio_playing')
 */
$streamUrl = optional($siteSettings)->radio_stream_url ?? null;
$nowText = optional($siteSettings)->radio_now_playing ?? null;
$schedule = optional($siteSettings)->radio_schedule ?? [];
?>
@if($streamUrl)
<div x-data="radioPlayer()" x-init="init()"
     class="fixed inset-x-0 bottom-0 z-40">
    <div class="container mx-auto px-4">
        <div class="mb-2 hidden sm:flex items-center justify-between text-xs text-gray-600">
            <div>
                <a href="/schedule" class="hover:underline">View Schedule</a>
            </div>
            <div class="italic" x-text="liveNowText"></div>
        </div>
        <div class="bg-white border border-gray-200 shadow-lg rounded-t-lg p-3 sm:p-4 flex items-center gap-3 sm:gap-4">
            <button @click="toggle()" :aria-label="playing ? 'Pause' : 'Play'"
                    class="w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center bg-blue-700 text-white">
                <template x-if="!playing">
                    <span>&#9658;</span>
                </template>
                <template x-if="playing">
                    <span>❚❚</span>
                </template>
            </button>
            <div class="min-w-0 flex-1">
                <div class="text-sm font-semibold truncate">Listen Live</div>
                <div class="text-xs text-gray-600 truncate" x-text="nowPlaying"></div>
            </div>
            <div class="hidden sm:flex items-center gap-2">
                <span class="text-xs text-gray-600">Vol</span>
                <input type="range" min="0" max="1" step="0.01" x-model="volume" @input="applyVolume()" class="w-28">
            </div>
            <audio x-ref="audio" preload="none" :src="stream"></audio>
        </div>
    </div>
</div>

<script>
function radioPlayer() {
    return {
        stream: @json($streamUrl),
        nowPlaying: @json($nowText) || 'Live Stream',
        schedule: @json($schedule ?? []),
        liveNowText: '',
        playing: false,
        volume: 0.9,
        init() {
            // restore play state
            try {
                const wasPlaying = sessionStorage.getItem('radio_playing') === '1';
                const vol = parseFloat(sessionStorage.getItem('radio_volume'));
                if (!isNaN(vol)) this.volume = vol;
                this.updateLiveNow();
                if (wasPlaying) { this.play(); }
                setInterval(() => this.updateLiveNow(), 60000);
            } catch (e) {}
        },
        toggle() { this.playing ? this.pause() : this.play(); },
        play() {
            const el = this.$refs.audio;
            if (!el) return;
            el.volume = this.volume;
            el.play().then(() => {
                this.playing = true;
                try { sessionStorage.setItem('radio_playing','1'); } catch(e){}
            }).catch(err => { console.warn('Play failed', err); });
        },
        pause() {
            const el = this.$refs.audio;
            if (!el) return;
            el.pause();
            this.playing = false;
            try { sessionStorage.setItem('radio_playing','0'); } catch(e){}
        },
        applyVolume() {
            const el = this.$refs.audio; if (el) el.volume = this.volume;
            try { sessionStorage.setItem('radio_volume', this.volume); } catch(e){}
        },
        updateLiveNow() {
            // Prefer admin-provided nowPlaying; if empty, compute from schedule by current time
            if (this.nowPlaying && this.nowPlaying.trim() !== '') {
                this.liveNowText = this.nowPlaying;
                return;
            }
            const days = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
            const now = new Date();
            const day = days[now.getDay()];
            const minutes = now.getHours()*60 + now.getMinutes();
            const todays = (this.schedule || []).filter(i => (i.day||'').toLowerCase() === day);
            for (const s of todays) {
                if (!s.start || !s.end) continue;
                const [sh, sm] = String(s.start).split(':').map(Number);
                const [eh, em] = String(s.end).split(':').map(Number);
                const startM = sh*60 + (sm||0);
                const endM = eh*60 + (em||0);
                if (minutes >= startM && minutes < endM) {
                    this.liveNowText = `${s.title || 'Live Show'}${s.host ? ' • ' + s.host : ''}`;
                    return;
                }
            }
            this.liveNowText = 'On Air';
        }
    }
}
</script>
@endif
