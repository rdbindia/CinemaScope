<template>
    <div>
        <h2 class="text-2xl font-semibold text-center mb-4">Total Sales by Theater</h2>
        <FilterChartByDate @update-dates="fetchSalesData" />

        <div v-if="chartData.datasets[0].data.every(sales => sales === 0)" class="text-center">
            <p>No sales data available for the selected date range.</p>
        </div>

        <TrendChart v-else :chartData="chartData" />
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import axios from 'axios';
import FilterChartByDate from '../components/FilterChartByDate.vue';
import TrendChart from '../components/TrendChart.vue';

export default defineComponent({
    name: 'TheaterTrend',
    components: {
        FilterChartByDate,
        TrendChart,
    },
    setup() {
        const chartData = ref({
            labels: [],
            datasets: [
                {
                    label: 'Top Sales ($)',
                    data: [],
                    backgroundColor: [],
                },
            ],
        });

        const fetchSalesData = async ({ startDate, endDate }) => {
            try {
                const response = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/trends`, {
                    params: {
                        start_date: startDate,
                        end_date: endDate,
                    },
                });

                const salesData = response.data.data;

                chartData.value.labels = salesData.map(item => item.theater_name);
                chartData.value.datasets[0].data = salesData.map(item => item.total_sales);
                chartData.value.datasets[0].backgroundColor = salesData.map(() => getRandomColor());
            } catch (error) {
                console.error('Error fetching sales data:', error.message);
            }
        };

        const getRandomColor = () => {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        };

        console.log(fetchSalesData);
        return {
            chartData,
            fetchSalesData,
        };
    },
});
</script>
