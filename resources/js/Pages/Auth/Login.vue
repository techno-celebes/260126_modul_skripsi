<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 p-4 rounded-xl bg-green-50 border-l-4 border-green-500 text-green-700 animate-fade-in">
            <i class="fa fa-check-circle me-2"></i>{{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="animate-slide-in">
                <InputLabel for="email" value="Email atau NIM/NIP" class="text-gray-700 font-semibold mb-2" />

                <TextInput
                    id="email"
                    type="text"
                    class="mt-2 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan email atau NIM/NIP"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="animate-slide-in" style="animation-delay: 0.1s;">
                <InputLabel for="password" value="Password" class="text-gray-700 font-semibold mb-2" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-2 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between animate-slide-in" style="animation-delay: 0.2s;">
                <label class="flex items-center cursor-pointer">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600 font-medium">Remember me</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-green-600 hover:text-green-700 font-semibold transition-colors duration-200"
                >
                    Lupa password?
                </Link>
            </div>

            <div class="animate-slide-in" style="animation-delay: 0.3s;">
                <PrimaryButton
                    class="w-full justify-center"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    <i class="fa fa-sign-in me-2"></i>
                    {{ form.processing ? 'Memproses...' : 'Masuk' }}
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
