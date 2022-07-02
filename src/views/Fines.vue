<template>
  <app-loader v-if="isLoading"/>
  <section v-show="!isLoading" v-cloak class="fines">
    <div class="fines__container container">
      <div class="fines-info">
      <div class="fines-info__inner">
        <div class="fines-info__all-price">
          <span>Всего назначено штрафов на сумму:</span>
          <p>{{ allFines }} ₽</p>
        </div>
        <div class="fines-info__btns">
          <button @click="upload('6')" class="fines-info__btn" :class="{'--active': route.query.range === '6'}">
            <span>Неделя</span>
            <p>{{ statistics.week }}</p>
          </button>
          <button @click="upload('30')" class="fines-info__btn" :class="{'--active': route.query.range === '30'}">
            <span>Месяц</span>
            <p>{{ statistics.mount }}</p>
          </button>
          <button @click="upload('90')" class="fines-info__btn" :class="{'--active': route.query.range === '90'}">
            <span>Квартал</span>
            <p>{{ statistics.quarter }}</p>
          </button>
          <button @click="upload('365')" class="fines-info__btn" :class="{'--active': route.query.range === '365'}">
            <span>Год</span>
            <p>{{ statistics.year }}</p>
          </button>
        </div>
      </div>
      <ul class="fines-info-categories categories">
        <li class="categories-item categories-item_1">
          <span>Административные штрафы</span>
          <p>{{ countsCategories.adm }}</p>
        </li>
        <li class="categories-item categories-item_2">
          <span>Малозначительно</span>
          <p>{{ countsCategories.insignificant }}</p>
        </li>
        <li class="categories-item categories-item_3">
          <span>Прекращено</span>
          <p>{{ countsCategories.law }}</p>
        </li>
        <li class="categories-item categories-item_4">
          <span>Предупреждения</span>
          <p>{{ countsCategories.warning }}</p>
        </li>
      </ul>
      </div>
      <div class="fines__chart" ref="chartEl"></div>
    </div>
  </section>
</template>

<script setup>
import {onMounted, ref, onBeforeUnmount} from "vue";
import {useRoute, useRouter} from "vue-router";
import {useStore} from "vuex";
import AppLoader from "@/components/AppLoader";
import finesChart from "@/use/finesChart";

const isLoading = ref(true);
const router = useRouter();
const route = useRoute();
const store = useStore();
const allFines = ref(1);
const week = ref([]);
const mount = ref([]);
const quarter = ref([]);
const year = ref([]);
const statistics = ref ({week: 0, mount: 0, quarter: 0, year: 0});
const countsCategories = ref({});
const chartEl = ref(null);
let globalChartJS = null;

onMounted(async () => {
  if (route.query.range) {
    await upload(['6', '30', '90', '365'].includes(route.query.range) ? route.query.range : '6');
  } else {
    await upload('6');
    router.replace({query: {range: '6'}});
  }
  await getYearData();
})

const getYearData = async () => {
  if (!year.value.length) {
    try {
      year.value = await store.dispatch('fines/getYearFines');
    } catch (e) {}
  }
  const masData = [7, 31, 91, year.value.length];
 Object.keys(statistics.value).forEach((key, idx) => {
   statistics.value[key] = year.value.slice(0, masData[idx]).reduce((acc, curr) => {
    return acc += curr.adm + curr.insignificant + curr.law + curr.warning
   }, 0)
 })
};

const upload = async (dayCount) => {
  if (dayCount === '6') {
    await checkRange(dayCount, week);
  }
  if (dayCount === '30') {
    await checkRange(dayCount, mount);
  }
  if (dayCount === '90') {
    await checkRange(dayCount, quarter);
  }
  if (dayCount === '365') {
    await checkRange(dayCount, year);
  }

  await router.replace({query: {range: dayCount}});
};

const checkRange = async (dayCount, variable) => {
  if (!variable.value.length) {
    try {
      variable.value = await store.dispatch('fines/getFines', dayCount);
    } catch (e) {}
  }
  isLoading.value = false;
  sumFines(variable.value);
  sumCategories(variable.value);
  if (globalChartJS) {
    globalChartJS.data = formatData(variable.value);
  } else {
    globalChartJS = finesChart(formatData(variable.value), chartEl.value);
  }
};

const sumCategories = (range) => {
  if (Array.isArray(range)) {
    countsCategories.value = range.reduce((acc, curr) => {
        acc.adm += +curr.adm;
        acc.insignificant += +curr.insignificant;
        acc.law += +curr.law;
        acc.warning += +curr.warning;
        return acc;
      },
      {
        adm: 0,
        insignificant: 0,
        law: 0,
        warning: 0,
      })
  } else {
    countsCategories.value = [];
  }
};

const sumFines = (data) => {
  allFines.value = data.reduce((acc, curr) => {
    if (curr.all) acc += curr.all;
    return acc;
  }, 0)
};

const formatData = (data) => {
  return data.map(item => ({
    date: item.date,
    price: item.all ?? 0,
    adm: item.adm,
    warning: item.warning,
    law: item.law,
    insignificant: item.insignificant,
  }));
};

onBeforeUnmount(() => {
  globalChartJS.dispose();
  console.log('isDisposed', globalChartJS.isDisposed());
});
</script>

<style scoped lang="scss" src="../css/pages/fines.scss"></style>