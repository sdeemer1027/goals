<script setup>
import { computed, onMounted, ref } from 'vue'

const props = defineProps({
    channels: {
        type: Array,
        default: () => [],
    },
})

const selectedChannel = ref(null)
const showGuide = ref(true)
const selectedProvider = ref('All')
const selectedCategory = ref('All')

const filteredChannels = computed(() => {
    return props.channels.filter((channel) => {
        const providerMatches =
            selectedProvider.value === 'All' ||
            channel.provider === selectedProvider.value

        const categoryMatches =
            selectedCategory.value === 'All' ||
            channel.category === selectedCategory.value

        return providerMatches && categoryMatches
    })
})


const categories = computed(() => {
    const values = props.channels
        .map((channel) => channel.category)
        .filter((category) => category)

    return ['All', ...new Set(values)]
})


function updateUrl() {
    const url = new URL(window.location.href)

    if (selectedProvider.value === 'All') {
        url.searchParams.delete('provider')
    } else {
        url.searchParams.set('provider', selectedProvider.value)
    }

    if (selectedCategory.value === 'All') {
        url.searchParams.delete('category')
    } else {
        url.searchParams.set('category', selectedCategory.value)
    }

    window.history.replaceState({}, '', url)
}

function selectProvider(provider) {
    selectedProvider.value = provider
    selectedCategory.value = 'All'

    updateUrl()
}


const providers = computed(() => {
    const grouped = {}

    filteredChannels.value.forEach((channel) => {
        if (!grouped[channel.provider]) {
            grouped[channel.provider] = []
        }

        grouped[channel.provider].push(channel)
    })

    return grouped
})

function selectChannel(channel) {
    selectedChannel.value = channel

    const url = new URL(window.location.href)

    url.searchParams.set('channel', channel.slug)

    window.history.replaceState({}, '', url)
}

function restoreSelectedChannel() {
    const params = new URLSearchParams(window.location.search)
    const channelSlug = params.get('channel')

    if (!channelSlug) {
        return
    }

    const channel = props.channels.find(
        (item) => item.slug === channelSlug
    )

    if (channel) {
        selectedChannel.value = channel
    }
}

onMounted(() => {
    restoreSelectedChannel()
})

function isPlayable(channel) {
    return ['embed', 'hls'].includes(channel?.stream_type)
}

function toggleGuide() {
    showGuide.value = !showGuide.value
}

function openFullscreen() {
    const screen = document.getElementById('tv-screen')

    if (!screen) {
        return
    }

    if (document.fullscreenElement) {
        document.exitFullscreen()
        return
    }

    screen.requestFullscreen()
}
</script>

<template>
    <div class="tv-page">

        <!-- TOP BAR -->
        <div class="tv-topbar">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="tv-title mb-0">TV Viewer</h1>
                        <small class="tv-subtitle">Live Television</small>
                    </div>

                    <button
                        type="button"
                        class="btn btn-outline-light btn-sm"
                        @click="toggleGuide"
                    >
                        {{ showGuide ? 'Hide Guide' : 'Show Guide' }}
                    </button>
                </div>
            </div>
        </div>

        <!-- MAIN TV AREA -->
        <div class="tv-layout">

            <!-- LEFT CHANNEL GUIDE -->
            <aside
                v-if="showGuide"
                class="channel-guide"
            >
               

<div class="guide-header">
    <span>CHANNEL GUIDE</span>

    <span>
        {{ filteredChannels.length }}
    </span>
</div>










<div class="provider-filters">
    <button
        type="button"
        class="filter-button"
        :class="{ active: selectedProvider === 'All' }"
        @click="selectProvider('All')"
    >
        All
    </button>

    <button
        type="button"
        class="filter-button"
        :class="{ active: selectedProvider === 'Pluto TV' }"
        @click="selectProvider('Pluto TV')"
    >
        Pluto TV
    </button>

    <button
        type="button"
        class="filter-button"
        :class="{ active: selectedProvider === 'Tubi TV' }"
        @click="selectProvider('Tubi TV')"
    >
        Tubi TV
    </button>

    <button
        type="button"
        class="filter-button"
        :class="{ active: selectedProvider === 'Test' }"
        @click="selectProvider('Test')"
    >
        Test
    </button>
</div>












<div class="category-filters">

    <button
        v-for="category in categories"
        :key="category"
        type="button"
        class="filter-button category-button"
        :class="{ active: selectedCategory === category }"
        @click="selectedCategory = category"
    >
        {{ category }}
    </button>

</div>




                <div
                    v-if="channels.length === 0"
                    class="empty-guide"
                >
                    No channels available.
                </div>

                <div
                    v-for="(providerChannels, provider) in providers"
                    :key="provider"
                    class="provider-section"
                >
                    <div class="provider-header">
                        {{ provider }}
                    </div>

                    <button
                        v-for="channel in providerChannels"
                        :key="channel.id"
                        type="button"
                        class="channel-row"
                        :class="{
                            selected:
                                selectedChannel?.id === channel.id
                        }"
                        @click="selectChannel(channel)"
                    >
                        <div class="channel-number">
                            {{ channel.sort_order }}
                        </div>

                        <div class="channel-icon">
    <img
        v-if="channel.logo_url"
        :src="channel.logo_url"
        :alt="channel.name"
        class="channel-logo"
    />

    <span v-else>
        TV
    </span>
</div>

                        <div class="channel-details">
                            <div class="channel-name">
                                {{ channel.name }}
                            </div>

                            <div
                                v-if="channel.category"
                                class="channel-category"
                            >
                                {{ channel.category }}
                            </div>
                        </div>
                    </button>
                </div>
            </aside>

            <!-- RIGHT TV VIEWER -->
            <main
                class="viewer-area"
                :class="{ 'viewer-full': !showGuide }"
            >
                <div class="viewer-card">

                    <!-- TV SCREEN -->
                    <div
                        id="tv-screen"
                        class="tv-screen"
                    >
                        <div
                            v-if="!selectedChannel"
                            class="screen-message"
                        >
                            <div class="tv-icon">📺</div>

                            <h2>TV Viewer</h2>

                            <p>
                                Select a channel from the guide.
                            </p>
                        </div>

                        <div
    v-else-if="isPlayable(selectedChannel)"
    class="playback-container"
>
    <iframe
        v-if="selectedChannel.stream_type === 'embed'"
        :src="selectedChannel.embed_url"
        class="tv-player"
        title="TV Player"
        allow="autoplay; fullscreen"
        allowfullscreen
    ></iframe>

    <video
    v-else-if="selectedChannel.stream_type === 'hls'"
    class="tv-player"
    controls
    autoplay
    playsinline
    muted
>
        <source
            :src="selectedChannel.stream_url"
            type="application/x-mpegURL"
        >
        Your browser does not support this video stream.
    </video>
</div>

<div
    v-else
    class="screen-message"
>
    <div class="live-badge">
        ● LIVE
    </div>

    <div class="tv-icon">
        📺
    </div>

    <h2>
        {{ selectedChannel.name }}
    </h2>

    <p>
        {{ selectedChannel.provider }}
    </p>

   <div
    v-if="selectedChannel.stream_type === 'external'"
    class="stream-placeholder"
>
    This channel is available through the provider.
</div>

<div
    v-else
    class="stream-placeholder"
>
    Playback is currently unavailable for this channel.
</div>
</div>

                        <button
                            type="button"
                            class="fullscreen-button"
                            title="Fullscreen"
                            @click="openFullscreen"
                        >
                            ⛶
                        </button>
                    </div>

                    <!-- CHANNEL INFORMATION -->
                    <div
                        v-if="selectedChannel"
                        class="channel-info"
                    >
                        <div>
                            <div class="current-label">
                                NOW PLAYING
                            </div>

                            <h2 class="current-channel">
                                {{ selectedChannel.name }}
                            </h2>

                            <div class="current-provider">
                                {{ selectedChannel.provider }}

                                <span
                                    v-if="selectedChannel.category"
                                >
                                    • {{ selectedChannel.category }}
                                </span>
                            </div>
                        </div>

                        <a
                            v-if="selectedChannel.external_url"
                            :href="selectedChannel.external_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="provider-button"
                        >
                            Open Provider
                        </a>
                    </div>

                    <div
                        v-if="selectedChannel?.description"
                        class="channel-description"
                    >
                        {{ selectedChannel.description }}
                    </div>

                </div>
            </main>

        </div>
    </div>
</template>

<style scoped>



.provider-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 10px;
    background: #111111;
    border-bottom: 1px solid #292929;
}

.category-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;

    padding: 8px 10px;

    background: #0d0d0d;

    border-bottom: 1px solid #292929;
}

.category-button {
    font-size: 0.68rem;
}



.filter-button {
    padding: 6px 10px;

    border: 1px solid #333333;
    border-radius: 5px;

    background: #080808;
    color: #999999;

    font-size: 0.72rem;
    font-weight: 600;

    cursor: pointer;
}

.filter-button:hover {
    background: #222222;
    color: #ffffff;
}

.filter-button.active {
    background: #333333;
    border-color: #555555;
    color: #ffffff;
}










.playback-container {
    width: 100%;
    height: 100%;
    min-height: 400px;
    background: #000000;
}

.tv-player {
    display: block;
    width: 100%;
    height: 100%;
    min-height: 400px;
    border: 0;
    background: #000000;
}


/* =========================================================
   TV PAGE
   ========================================================= */

.tv-page {
    min-height: 100vh;
    background: #000000;
    color: #ffffff;
}


/* =========================================================
   TOP BAR
   ========================================================= */

.tv-topbar {
    background: #080808;
    border-bottom: 1px solid #292929;
    padding: 15px 20px;
}

.tv-title {
    font-size: 1.6rem;
    font-weight: 600;
}

.tv-subtitle {
    color: #888888;
}


/* =========================================================
   MAIN TV LAYOUT
   LEFT = GUIDE
   RIGHT = VIEWER
   ========================================================= */

.tv-layout {
    display: grid;
    grid-template-columns: 320px minmax(0, 1fr);
    gap: 20px;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
}


/* =========================================================
   CHANNEL GUIDE
   ========================================================= */

.channel-guide {
    background: #111111;
    border: 1px solid #292929;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);

    /* Keep guide independent from viewer */
    align-self: start;
}

.guide-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 15px;

    background: #080808;

    border-bottom: 1px solid #292929;

    font-size: 0.85rem;
    font-weight: 700;

    letter-spacing: 0.08em;

    color: #dddddd;
}

.provider-section {
    border-top: 1px solid #292929;
}

.provider-header {
    padding: 10px 15px;

    background: #080808;

    color: #aaaaaa;

    font-size: 0.8rem;
    font-weight: 700;

    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.channel-row {
    width: 100%;

    display: flex;
    align-items: center;

    gap: 10px;

    padding: 12px;

    border: 0;
    border-bottom: 1px solid #292929;

    background: #111111;

    color: #ffffff;

    text-align: left;

    cursor: pointer;

    transition:
        background 0.15s ease,
        transform 0.15s ease;
}

.channel-row:hover {
    background: #222222;
}

.channel-row.selected {
    background: #333333;
}

.channel-number {
    width: 28px;

    color: #888888;

    font-size: 0.75rem;

    text-align: center;
}

.channel-icon {
    width: 38px;
    height: 38px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 6px;

    background: #292929;

    font-size: 0.7rem;
    font-weight: 700;
}
.channel-logo {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 6px;
}

.channel-row.selected .channel-icon {
    background: #555555;
}

.channel-details {
    min-width: 0;
}

.channel-name {
    font-weight: 600;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.channel-category {
    margin-top: 2px;

    color: #888888;

    font-size: 0.75rem;
}

.empty-guide {
    padding: 30px 15px;

    color: #888888;

    text-align: center;
}


/* =========================================================
   VIEWER AREA
   ========================================================= */

.viewer-area {
    min-width: 0;
    width: 100%;
}

.viewer-full {
    grid-column: 1 / -1;
}


/* =========================================================
   VIEWER CARD
   ========================================================= */

.viewer-card {
    width: 100%;

    background: #080808;

    border: 1px solid #292929;

    border-radius: 10px;

    overflow: hidden;

    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6);
}


/* =========================================================
   TV SCREEN
   ========================================================= */

.tv-screen {
    position: relative;

    width: 100%;

    aspect-ratio: 16 / 9;

    min-height: 400px;

    background: #000000;

    display: flex;

    align-items: center;

    justify-content: center;
}

.screen-message {
    text-align: center;

    padding: 30px;
}

.tv-icon {
    font-size: 4rem;

    margin-bottom: 15px;
}

.screen-message h2 {
    font-size: 1.6rem;

    margin-bottom: 8px;
}

.screen-message p {
    color: #888888;

    margin-bottom: 0;
}


/* =========================================================
   LIVE BADGE
   ========================================================= */

.live-badge {
    display: inline-block;

    padding: 4px 9px;

    margin-bottom: 15px;

    border-radius: 4px;

    background: #b00000;

    color: #ffffff;

    font-size: 0.75rem;

    font-weight: 700;

    letter-spacing: 0.05em;
}

.stream-placeholder {
    margin-top: 20px;

    color: #666666;

    font-size: 0.9rem;
}


/* =========================================================
   FULLSCREEN
   ========================================================= */

.fullscreen-button {
    position: absolute;

    right: 15px;
    bottom: 15px;

    width: 40px;
    height: 40px;

    border: 1px solid #444444;

    border-radius: 6px;

    background: rgba(20, 20, 20, 0.9);

    color: #ffffff;

    font-size: 1.3rem;

    cursor: pointer;
}

.fullscreen-button:hover {
    background: #333333;
}


/* =========================================================
   CHANNEL INFORMATION
   ========================================================= */

.channel-info {
    display: flex;

    justify-content: space-between;
    align-items: center;

    gap: 20px;

    padding: 20px;

    background: #111111;

    border-top: 1px solid #292929;
}

.current-label {
    color: #888888;

    font-size: 0.7rem;

    font-weight: 700;

    letter-spacing: 0.1em;
}

.current-channel {
    margin: 4px 0;

    font-size: 1.4rem;

    font-weight: 600;
}

.current-provider {
    color: #888888;

    font-size: 0.85rem;
}

.provider-button {
    flex-shrink: 0;

    padding: 9px 15px;

    border-radius: 6px;

    background: #333333;

    color: #ffffff;

    text-decoration: none;

    font-size: 0.85rem;

    font-weight: 600;
}

.provider-button:hover {
    background: #444444;

    color: #ffffff;
}

.channel-description {
    padding: 15px 20px;

    border-top: 1px solid #292929;

    background: #080808;

    color: #888888;

    font-size: 0.9rem;
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 900px) {

    .tv-layout {
        grid-template-columns: 260px minmax(0, 1fr);

        gap: 15px;

        padding: 15px;
    }

    .tv-screen {
        min-height: 300px;
    }

    .tv-icon {
        font-size: 3rem;
    }
}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 700px) {

    .tv-layout {
        display: flex;

        flex-direction: column;

        padding: 10px;
    }

    /*
     * On phones the guide moves above the viewer.
     * This is intentional because there is not enough
     * horizontal space for a usable two-column layout.
     */

    .channel-guide {
        width: 100%;
    }

    .viewer-area {
        width: 100%;
    }

    .tv-screen {
        min-height: 250px;
    }

    .channel-info {
        flex-direction: column;

        align-items: flex-start;
    }

    .provider-button {
        width: 100%;

        text-align: center;
    }

    .tv-title {
        font-size: 1.25rem;
    }
}
</style>