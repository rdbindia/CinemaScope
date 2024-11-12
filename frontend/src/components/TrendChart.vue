<template>
    <div class="chart-wrapper">
        <canvas ref="chartRef" class="chart-container" width="600" height="400"></canvas>
    </div>
</template>

<script>
import { defineComponent, ref, watch, onMounted } from 'vue';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from 'chart.js';

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
            responsive: false,
            maintainAspectRatio: true,
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
            if (chartRef.value && chartRef.value.getContext) {
                if (chartInstance.value) {
                    chartInstance.value.destroy();
                }

                chartInstance.value = new ChartJS(chartRef.value.getContext('2d'), {
                    type: 'bar',
                    data: props.chartData,
                    options: chartOptions,
                });
            }
        };

        watch(
            () => props.chartData,
            (newVal, oldVal) => {
                if (newVal !== oldVal) {
                    renderChart();
                }
            }
        );

        onMounted(() => {
            renderChart();
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
}

.chart-container {
    width: 100%;
    height: 100%;
}
</style>
