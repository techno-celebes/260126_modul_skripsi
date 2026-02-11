<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const show = ref(false);
const page = usePage();

const getParticleStyle = (index) => {
    const angle = (index / 30) * 360;
    const distance = 40 + (index % 3) * 20;
    return {
        left: `${50 + Math.cos(angle * Math.PI / 180) * distance}%`,
        top: `${50 + Math.sin(angle * Math.PI / 180) * distance}%`,
        animationDelay: `${index * 0.1}s`,
        animationDuration: `${2 + (index % 3)}s`
    };
};

onMounted(() => {
    if (page.props.showLogoSplash) {
        show.value = true;
        
        setTimeout(() => {
            show.value = false;
        }, 4000);
    }
});

const removeSplash = () => {
    show.value = false;
};
</script>

<template>
    <Transition
        enter-active-class="transition-opacity duration-500"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity duration-700"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="show"
            @click="removeSplash"
            class="fixed inset-0 z-[9999] flex items-center justify-center overflow-hidden cursor-pointer"
        >
            <!-- Animated Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-green-500 to-teal-600">
                <div class="wave wave1"></div>
                <div class="wave wave2"></div>
                <div class="wave wave3"></div>
            </div>
            
            <!-- Particles -->
            <div class="particles">
                <div v-for="i in 30" :key="i" class="particle" :style="getParticleStyle(i)"></div>
            </div>
            
            <!-- Logo Container -->
            <div class="logo-container">
                <div class="logo-ring ring1"></div>
                <div class="logo-ring ring2"></div>
                <div class="logo-ring ring3"></div>
                
                <div class="logo-wrapper">
                    <div class="logo-glow"></div>
                    <img
                        src="/image/one-time-uin-logo.png"
                        alt="UIN Logo"
                        class="logo-main"
                    />
                </div>
                
                <!-- Light Rays -->
                <div class="rays">
                    <div v-for="i in 12" :key="i" class="ray" :style="`transform: rotate(${i * 30}deg)`"></div>
                </div>
            </div>
            
            <!-- Text -->
            <div class="welcome-text">
                <h1 class="text-white text-4xl font-bold tracking-wider">SELAMAT DATANG</h1>
                <p class="text-white/90 text-lg mt-2">Sistem Informasi Akademik</p>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
/* Background Waves */
.wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 200%;
    height: 100%;
    background: linear-gradient(transparent, rgba(255, 255, 255, 0.1));
    animation: wave 8s linear infinite;
}

.wave1 {
    animation-delay: 0s;
    opacity: 0.3;
}

.wave2 {
    animation-delay: -2s;
    opacity: 0.2;
}

.wave3 {
    animation-delay: -4s;
    opacity: 0.1;
}

@keyframes wave {
    0% {
        transform: translateX(0) translateY(0) rotate(0deg);
    }
    100% {
        transform: translateX(-50%) translateY(10%) rotate(360deg);
    }
}

/* Particles */
.particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.particle {
    position: absolute;
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
    animation: particleFloat 3s ease-in-out infinite;
}

@keyframes particleFloat {
    0%, 100% {
        transform: translateY(0) scale(0);
        opacity: 0;
    }
    50% {
        transform: translateY(-100px) scale(1);
        opacity: 1;
    }
}

/* Logo Container */
.logo-container {
    position: relative;
    z-index: 10;
    animation: logoEntrance 1.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes logoEntrance {
    0% {
        transform: translateY(100vh) scale(0.3) rotateY(180deg) rotateX(90deg);
        opacity: 0;
    }
    50% {
        transform: translateY(-30px) scale(1.15) rotateY(10deg) rotateX(-10deg);
    }
    70% {
        transform: translateY(15px) scale(0.95) rotateY(-5deg) rotateX(5deg);
    }
    100% {
        transform: translateY(0) scale(1) rotateY(0deg) rotateX(0deg);
        opacity: 1;
    }
}

/* Rings */
.logo-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: ringPulse 2s ease-out infinite;
}

.ring1 {
    width: 280px;
    height: 280px;
    animation-delay: 0s;
}

.ring2 {
    width: 350px;
    height: 350px;
    animation-delay: 0.3s;
}

.ring3 {
    width: 420px;
    height: 420px;
    animation-delay: 0.6s;
}

@keyframes ringPulse {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0;
    }
    50% {
        opacity: 0.6;
    }
    100% {
        transform: translate(-50%, -50%) scale(1.3);
        opacity: 0;
    }
}

/* Logo Wrapper */
.logo-wrapper {
    position: relative;
    animation: logoFloat 3s ease-in-out infinite;
    transform-style: preserve-3d;
}

@keyframes logoFloat {
    0%, 100% {
        transform: translateY(0) rotateY(0deg);
    }
    25% {
        transform: translateY(-15px) rotateY(5deg);
    }
    50% {
        transform: translateY(0) rotateY(0deg);
    }
    75% {
        transform: translateY(-15px) rotateY(-5deg);
    }
}

.logo-main {
    width: 280px;
    height: auto;
    position: relative;
    z-index: 2;
    filter: drop-shadow(0 25px 50px rgba(255, 255, 255, 0.6));
    animation: logoGlow 2s ease-in-out infinite;
}

@keyframes logoGlow {
    0%, 100% {
        filter: drop-shadow(0 25px 50px rgba(255, 255, 255, 0.6));
    }
    50% {
        filter: drop-shadow(0 30px 70px rgba(255, 255, 255, 0.9));
    }
}

.logo-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.6) 0%, transparent 70%);
    animation: glowExpand 2s ease-in-out infinite;
    z-index: 1;
}

@keyframes glowExpand {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.6;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.3);
        opacity: 0.9;
    }
}

/* Light Rays */
.rays {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 500px;
    height: 500px;
    transform: translate(-50%, -50%);
    animation: raysRotate 20s linear infinite;
}

@keyframes raysRotate {
    from {
        transform: translate(-50%, -50%) rotate(0deg);
    }
    to {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}

.ray {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 4px;
    height: 250px;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), transparent);
    transform-origin: center top;
    opacity: 0;
    animation: rayPulse 3s ease-in-out infinite;
}

.ray:nth-child(odd) {
    animation-delay: 0.5s;
}

@keyframes rayPulse {
    0%, 100% {
        opacity: 0;
        height: 200px;
    }
    50% {
        opacity: 0.6;
        height: 280px;
    }
}

/* Welcome Text */
.welcome-text {
    position: absolute;
    bottom: 15%;
    text-align: center;
    animation: textFadeIn 1s ease-out 0.8s both;
}

@keyframes textFadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.welcome-text h1 {
    animation: textGlow 2s ease-in-out infinite;
}

@keyframes textGlow {
    0%, 100% {
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    }
    50% {
        text-shadow: 0 0 40px rgba(255, 255, 255, 0.9);
    }
}
</style>
