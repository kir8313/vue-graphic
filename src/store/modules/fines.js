export default {
  namespaced: true,

  actions: {
    async getFines(_, range) {
      try {
        const response = await fetch(`${process.env.VUE_APP_DB}${range}.json`);
        const result = await response.json();
        console.log('result', result);
        if (!result) {
          throw new Error('Ошибка при получении данных');
        }
        return result;
      } catch (e) {
        console.log('Ошибка', e);
      }
    },

    async getYearFines() {
      try {
        const response = await fetch(process.env.VUE_APP_DB + '365.json');
        const result = await response.json();
        console.log('result year', result);
        if (!result) {
          throw new Error('Ошибка при получении данных');
        }
        return result;
      } catch (e) {
        console.log('Ошибка', e);
      }
    }
  }
}