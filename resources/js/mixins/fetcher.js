//import DEFAULT_API_SERVER from './app.constants';

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
    },
    fetchChapterPages(id) {
       return new Promise((resolve, reject) => {
          axios.get('/api/v1/chapter/'+id,
          {
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Authorization': window.localStorage.getItem('token'),
                "X-RapidAPI-Host": "manga-series.p.rapidapi.com",
                "X-RapidAPI-Key": "6e0536a34amsh5bafc6c01c9d79cp158517jsn184ed7ad3b7d"
              }
          }).then(resp => {
              console.log(resp);
              resolve(resp.data.images);
          }).catch(error => console.log(error));
       });

    },
  }
};
