export default {
  methods: {
    fetchMangaIds() {
    /**
      axios.get('https://www.mangaeden.com/ajax/login/?username=mfinnigan&password=F655C2FgZB4cfqt').then(resp => {
      axios.get('https://www.mangaeden.com/api/list/0')
      */
      return new Promise((resolve, reject) => axios.get('/data/mangaIDs.json').then(resp => {
        resolve(resp.data.manga);
      }));
    },
    fetchMangaData() {
      return new Promise((resolve, reject) => axios.get('/data/mangaDetails.json').then(resp => {
        resolve(resp.data);
      }));
    }
  }
};