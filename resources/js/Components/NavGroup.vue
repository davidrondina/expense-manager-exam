<script setup>
    import { ref } from 'vue';

    const props = defineProps({
        label: String,
    });

</script>

<template>
    <div class="space-y-2">
        <span class="px-1 py-1 text-sm font-semibold text-white">{{ label ?? 'Label' }}</span>

        <div class="pl-4 space-y-2">
            <slot />
        </div>
    </div>
</template>
