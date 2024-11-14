<template>
    <form @submit.prevent="submitDates" class="date-range-form">
        <label>
            Start Date:
            <input type="date" v-model="startDate" required />
        </label>
        <label>
            End Date:
            <input type="date" v-model="endDate" :min="startDate" required />
        </label>
        <button type="submit" class="text-indigo-600">Generate Chart</button>
    </form>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';

export default defineComponent({
    name: 'FilterChartByDate',
    emits: ['update-dates'],
    setup(_, { emit }) {
        const startDate = ref('');
        const endDate = ref('');

        onMounted(() => {
            const today = new Date().toISOString().split('T')[0];
            startDate.value = today;
            endDate.value = today;
            emit('update-dates', { startDate: today, endDate: today });
        });

        const submitDates = () => {
            emit('update-dates', { startDate: startDate.value, endDate: endDate.value });
        };

        return {
            startDate,
            endDate,
            submitDates,
        };
    },
});
</script>

<style scoped>
.date-range-form {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}
</style>
