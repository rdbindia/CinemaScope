<template>
    <div class="chart-wrapper">
        <canvas ref="chartRef" class="chart-container" width="600" height="400"></canvas>
    </div>
</template>

<script>
import { defineComponent, ref, watch, onMounted, onUnmounted } from 'vue';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
import { Bar } from 'vue-chartjs';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default defineComponent({
    name: 'TrendChart',
    props: {
        chartData: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
        const chartRef = ref(null);
        const chartInstance = ref(null);

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Sales ($)',
                    },
                },
                x: {
                    title: {
                        display: true,
                        text: 'Theater',
                    },
                },
            },
        };

        const renderChart = () => {
            if (chartInstance.value) {
                chartInstance.value.destroy();
            }

            if (chartRef.value) {
                chartInstance.value = new ChartJS(chartRef.value.getContext('2d'), {
                    type: 'bar',
                    data: JSON.parse(JSON.stringify(props.chartData)),
                    options: chartOptions,
                });
            }
        };

        watch(
            () => props.chartData,
            (newVal) => {
                if (newVal) {
                    renderChart();
                }
            },
            {
                immediate: true,
                deep: true
            }
        );

        onMounted(() => {
            renderChart();
        });

        onUnmounted(() => {
            if (chartInstance.value) {
                chartInstance.value.destroy();
            }
        });

        return {
            chartRef,
        };
    },
});
</script>

<style scoped>
.chart-wrapper {
    position: relative;
    max-width: 100%;
    height: 100%;
}

.chart-container {
    width: 100%;
    height: 100%;
}
</style>
