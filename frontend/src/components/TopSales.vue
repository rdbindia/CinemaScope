<template>
    <div class="container mx-auto p-6 max-w-lg">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-center mb-4 text-fuchsia-900">Find Top Sales for a Date</h2>

            <input
                v-model="date"
                type="date"
                placeholder="YYYY-MM-DD"
                class="w-full p-2 border rounded-md mb-4 text-gray-700 focus:outline-none focus:border-blue-500"
                @change="fetchTopSales"
            >

            <div v-if="error" class="text-red-500 mt-4 text-center">{{ error }}</div>

            <div v-if="sales" class="mt-6 bg-gray-100 p-4 rounded">
                <h3 class="text-xl font-semibold text-center text-fuchsia-900">Top Theater on {{ date }}:</h3>
                <p class="text-center mt-2" v-for="sale in sales" :key="sale.id">
                    <span class="font-semibold text-fuchsia-900">{{ sale.theater }}</span> -
                    <span class="text-green-600 font-bold text-fuchsia-900">${{ sale.total_sales }}</span>
                </p>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';

export default {
    name: 'TopSales',
    data() {
        return {
            date: '',
            sales: null,
            error: null,
        };
    },
    methods: {
        async fetchTopSales() {
            this.sales = null;
            this.error = null;

            if (!this.date) {
                this.error = 'Please enter a valid date.';
                return;
            }

            try {
                const response = await axios.get(
                    `${import.meta.env.VITE_API_BASE_URL}/sale?date=${this.date}`
                );

                if (response.data.success) {
                    this.sales = response.data.data;
                } else {
                    this.error = response.data.message || 'No data found for this date.';
                }
            } catch (err) {
                console.error('Error fetching top sales:', err);
                this.error = 'No data available for this date.';
            }
        },
    },
};
</script>

<style scoped>

</style>
