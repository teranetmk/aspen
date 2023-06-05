<script>
import Chart from 'chart.js/auto';
import { CountUp } from 'countup.js';
import { onMount, afterUpdate } from 'svelte';

export let title, tooltip, suffix, subtitle;
export let score = 0;
let canvas, chart;
let countUp, scoreEl;

function createChart() {
  chart = new Chart( canvas, {
    type: 'doughnut',
    data: {
      datasets: [
        {
          label: title,
          data: [100],
          backgroundColor: ['rgba(255,255,255,0.3'],
          borderColor: ['transparent'],
        },
      ],
    },
    options: {
      circumference: 180,
      rotation: -90,
      aspectRatio: 2,
      spacing: 0,
      cutout: '65%',
      animation: false,
      datasets: {
        doughnut: {
          borderRadius: 2,
          borderWidth: 0,
          borderColor: 'transparent',
        },
      },
    },
  });
  }

let gradient;
function getGradient(ctx, chartArea) {
  if (!gradient) {
    gradient = ctx.createLinearGradient(chartArea.left, 0, chartArea.right, 0);
    gradient.addColorStop(0, 'rgba(255,255,255,0.5)')
    gradient.addColorStop(0.3, 'rgba(255,255,255,1)')
    // gradient.addColorStop(1, 'rgba(255,255,255,1)')
  }
  return gradient;
}

function updateChart() {
  chart.data.datasets[0].data = [score, 100-score];
  chart.data.datasets[0].backgroundColor = ['rgba(255,255,255,1)', 'transparent'];
  chart.data.datasets[0].backgroundColor = function(context) {
    const chart = context.chart;
    const { ctx, chartArea } = chart;
    return [getGradient(ctx, chartArea), 'rgba(255,255,255,0.3'];
  },
  chart.options.animation = true;
  chart.update();
}

function doCountUp() {
  countUp = new CountUp( scoreEl, score, {
    suffix: suffix,
    duration: 1.5,
  });
  countUp.start();
}

onMount(createChart);

afterUpdate(() => {
  updateChart();
  doCountUp();
})
</script>

<div class="statbox">
  <div class="title">{title}</div>
  <div class=chart-container>
    <canvas bind:this={canvas}></canvas>
    <span class="min">0</span>
    <span class="max">100</span>
    <span class="score" bind:this={scoreEl}></span>
  </div>
  <div class="tooltip-container">
    <span class="tooltip">
    <i class="fas fa-info fa-fw"></i>
    </span>
    <span class="tooltip_text">{@html tooltip}</span>
  </div>
  {#if subtitle}
    <div class="subtitle">{@html subtitle}</div>
  {/if}
</div>

<style>
.statbox{
  position: relative;
  padding: 10px 20px 40px;
  color: white;
}
.title {
  font-size: 18px;
  line-height: 1;
  margin-bottom: 15px;
}
.chart-container {
  position: relative;
}
.chart-container > span {
  position: absolute;
  line-height: 1;
  top: 100%;
}
.min, .max {
  transform: translateY(5px);
  font-size: 12px;
}
.min {
  left: 10%;
}
.max {
  right: 8%;
}
.score {
  left: 50%;
  transform: translate(-50%, -100%);
  font-size: 36px;
  font-weight: bold;
  line-height: 1;
}
.tooltip-container {
  position: absolute !important;
  right: 20px;
  top: 10px;
}
.tooltip-container > span.tooltip {
  border: 2px solid white;
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 20px;
  height: 20px;
}
.fa-info {
  font-size: 8px;
}
.tooltip {
  margin: 0;
}
.tooltip_text {
  right: 0;
  left: auto;
}
.subtitle {
  position: absolute;
  bottom: 2px;
  left: 0;
  right: 0;
  font-size: 11px;
  /* margin: 12px auto 0; */
  text-align: center;
}
</style>
