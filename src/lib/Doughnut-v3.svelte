<script>
import Chart from 'chart.js/auto';
import { onMount, afterUpdate } from 'svelte';

export let title, tooltip;
export let score = 0;
let canvas, chart;

function createChart() {
  chart = new Chart( canvas, {
    type: 'doughnut',
    data: {
      datasets: [{
        label: title,
        data: [3, 0],
        backgroundColor: ['rgba(255,255,255,0.3'],
        borderColor: ['transparent'],
      }],
    },
    options: {
      events: [],
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
      plugins: {
        tooltip: {
          enabled: true,
        },
      },
    },
  });
  }

function setColor(score) {
    if (score === 3) {
      return '#1073CF';
    } else if (score === 2) {
      return '#FFA000';
    }
    return '#E24444';
}
function updateChart() {
  chart.data.datasets[0].data = [score, 3-score];
  chart.data.datasets[0].backgroundColor = [setColor(score), '#E5E5E5'];
  chart.options.animation = true;
  chart.update();
}

onMount(createChart);

afterUpdate(() => {
  updateChart();
})
</script>

<div class="statbox">
  <div style="display: flex;">
    <h4 class="title">{title}</h4>
    <div class="tooltip-container">
      <span class="tooltip">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect width="16" height="16" fill="white"></rect>
          <path d="M0.375 8C0.375 9.63844 0.463281 10.9295 0.689631 11.948C0.915035 12.9622 1.27234 13.683 1.79467 14.2053C2.31699 14.7277 3.03782 15.085 4.05204 15.3104C5.07053 15.5367 6.36156 15.625 8 15.625C9.63844 15.625 10.9295 15.5367 11.948 15.3104C12.9622 15.085 13.683 14.7277 14.2053 14.2053C14.7277 13.683 15.085 12.9622 15.3104 11.948C15.5367 10.9295 15.625 9.63844 15.625 8C15.625 6.36156 15.5367 5.07053 15.3104 4.05204C15.085 3.03782 14.7277 2.31699 14.2053 1.79467C13.683 1.27234 12.9622 0.915035 11.948 0.689631C10.9295 0.463281 9.63844 0.375 8 0.375C6.36156 0.375 5.07053 0.463281 4.05204 0.689631C3.03782 0.915035 2.31699 1.27234 1.79467 1.79467C1.27234 2.31699 0.915035 3.03782 0.689631 4.05204C0.463281 5.07053 0.375 6.36156 0.375 8Z" stroke="black" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"></path>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M8.66666 11.3333C8.66666 11.7015 8.36818 12 7.99999 12C7.63181 12 7.33333 11.7015 7.33333 11.3333V7.33333C7.33333 6.96514 7.63181 6.66667 7.99999 6.66667C8.36818 6.66667 8.66666 6.96514 8.66666 7.33333V11.3333ZM7.99999 6C7.63181 6 7.33333 5.70152 7.33333 5.33333C7.33333 4.96514 7.63181 4.66667 7.99999 4.66667C8.36818 4.66667 8.66666 4.96514 8.66666 5.33333C8.66666 5.70152 8.36818 6 7.99999 6Z" fill="black"></path>
          </svg>
      </span>
      <span class="tooltip_text">{@html tooltip}</span>
    </div>
  </div>
  <div class=chart-container>
    <canvas bind:this={canvas}></canvas>
    <span class="min">Below Average</span>
    <span class="avg">Average</span>
    <span class="max">Above Average</span>
    {#if score === 1}
      <div class="bubble poor">
        <span>
          You Can Do It!
        </span>
        <div class="tooltip-arrow">
        </div>
      </div>
    {/if}
    {#if score === 2}
      <div class="bubble average">
        <span>
          Good Job!
        </span>
        <div class="tooltip-arrow">
        </div>
      </div>
    {/if}
    {#if score === 3}
      <div class="bubble great">
        <span>
          You're ahead of the pack!
        </span>
        <div class="tooltip-arrow">
        </div>
      </div>
    {/if}
  </div>
  
</div>

<style>
.statbox{
  position: relative;
  padding: 10px 20px 40px;
  color: black;
  display: flex;
  flex-direction: column;
}
.title {
  font-weight: 400;
  font-size: 26px;
  line-height: 1;
  margin-bottom: 15px;
}
.chart-container {
  position: relative;
  padding-top: 20px;
  max-width: 238px;
  margin: 0 auto;
}
.chart-container > span {
  position: absolute;
  line-height: 1;
  top: 100%;
}
.min, .max, .avg {
  transform: translateY(5px);
  font-weight: bold;
  font-size: 12px;
}
.min {
  left: 0;
}
.max {
  right: 0;
}
.avg {
  left: 40%;
  top: 55% !important;
}
.tooltip-container {
  margin-left: 4px;
}
.tooltip-container > span.tooltip {
  /* border: 1px solid black; */
  border-radius: 8px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 20px;
  height: 20px;
  text-align: left;
}
.tooltip {
  margin: 0;
}
.tooltip_text {
  left: 0;
  transform: translateX(-50%);
  text-align: left;
}
@media only screen and (max-width: 480px) {
  .tooltip_text {
    left: auto;
    right: 0;
    transform: translateX(30px);
    text-align: left;
  }
}
.bubble {
  position: absolute;
  box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
  border-radius: 8px;
  font-size: 10px;
  font-weight: bold;
  padding: 8px 10px;
  background: white;
  max-width: 100px;
  line-height: 1.2;
  transform: rotate(-0.14deg);
  text-align: center;
}
.bubble span {
  display: inline-block;
}
.bubble.poor {
  left: -100px;
  bottom: 25%;
  box-shadow: 6px 6px 10px #00000040;
}
.bubble.average {
  left: 50%;
  top: -9px;
  transform: translateX(-50%);
  box-shadow: 0px 4px 6px #00000040;
}
.bubble.great {
  right: -100px;
  bottom: 25%;
  box-shadow: -6px 6px 10px #00000040;
}
.bubble .tooltip-arrow{
  width: 15px;
  height: 15px;
  position: absolute;
  background: #FFFFFF;
  transform: rotate(44.35deg) translateX(-50%);
}
.bubble.poor .tooltip-arrow {
  right: -11px;
  top: 18px;
}
.bubble.average .tooltip-arrow {
  left: 50%;
  top: 25px;
}
.bubble.great .tooltip-arrow {
  left: -2px;
  top: 18px;
}
@media only screen and (max-width: 1350px) {
  .bubble.great{
    right: -56px;
    bottom: 58%;
  }
}
@media only screen and (max-width: 1150px) {
  .bubble.bubble.great {
    left: 85%;
    top: -8px;
    bottom: auto;
    transform: translateX(-50%);
  }
  .bubble.bubble.poor {
    left: 15%;
    top: -8px;
    bottom: auto;
    transform: translateX(-50%);
  }
  .bubble.great .tooltip-arrow {
    left: 35%;
    top: 38px;
  }
  .bubble.poor .tooltip-arrow {
    left: 65%;
    top: 38px;
  }
}
</style>
