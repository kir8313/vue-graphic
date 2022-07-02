export default {
  namespaced: true,

  actions: {
    async getFines(_, range) {
      try {
        const response = await fetch('https://test-834e2-default-rtdb.europe-west1.firebasedatabase.app/' + range + '.json');
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
        const response = await fetch('https://test-834e2-default-rtdb.europe-west1.firebasedatabase.app/' + '365' + '.json');
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