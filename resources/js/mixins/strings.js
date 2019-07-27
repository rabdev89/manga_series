export default {
  methods: {
    convertStatus(status) {
      if(status == 2) {
        return 'Completed';
      } else if(status == 1) {
        return 'Ongoing';
      }
      return '?';
    },
    formatNum(num) {
      num = num.toString();
      if(num.length == 4) {
        return num[0]+','+num.substr(1, 3);
      } else if(num.length == 5) {
        return num.substr(0, 2) +','+num.substr(2, 4);
      } else if(num.length == 6) {
        return num.substr(0, 3) +','+num.substr(3, 5);
      } else if(num.length == 7) {
        return num[0] +','+num.substr(1, 3) +','+num.substr(4, 6);
      } else if(num.length == 8) {
        return num[0] + '' + num[1] +'M+';
      } else if(num.length == 9) {
        return num[0] + '' +num[1] + num[2] + 'M+';
      } else if(num.length == 10) {
        return num[0] + 'B+';
      }
      return num;
    },
    toSlug(str) {
      return str.replace(/ /g, '-').toLowerCase();
    },
    normalize(str) {
      return str.replace(/-/g,' ').toUpperCase();
    },
    formatDate(unix) {
      var a = new Date(unix * 1000);
      var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
      var year = a.getFullYear();
      var month = months[a.getMonth()];
      var date = a.getDate();
      var time = date + ' ' + month + ' ' + year;
      return time;
    },
    //should be replaced with mySQL query
    // is strict
    advancedSearch(mangas, params) {
      let results = [];
      mangas.forEach((manga) => {
        //merge title with aka
        manga.aka.push(manga.title);
        let matches = true;
        let hasOneMatch = true;
        params.forEach((param) => {
          let key = Object.keys(param)[0];
          param = param[key].toString().toLowerCase();
          if(param && manga[key]) {
            if(Array.isArray(manga[key])) {
              hasOneMatch = false;
              manga[key].forEach((val) => {
                val = val.toString().toLowerCase();;
                if(val.indexOf(param) !== -1) {
                  hasOneMatch = true;
                }
              });
            } else {
              manga[key] = manga[key].toString().toLowerCase();
              matches = manga[key].indexOf(param) !== -1;
            }
          } else {
            matches = false;
          }
        });
        if(matches && hasOneMatch) {
          results.push(manga);
        }
      });
      return results.sort((a, b) => { return b.hits - a.hits;});
    }
  }
}