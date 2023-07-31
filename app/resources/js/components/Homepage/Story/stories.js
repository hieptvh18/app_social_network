import { defineStore } from 'pinia';

export const useStoriesStore = defineStore('stories', {
  state: () => {
    return {
      stories: [
        {
          id: 1,
          title: 'hieptvh',
          img: '',
          bg: 'https://images.pexels.com/photos/1229861/pexels-photo-1229861.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260',
          storiesGroup: [
            {
              title: 'coding...',
              text: '',
              img: '',
              bg: 'https://www.parkersoftware.com/wp-content/uploads/2020/10/pankaj-patel-_SgRNwAVNKw-unsplash-scaled.jpg'
            },
            {
              title: 'learning',
              text: '',
              img: '',
              bg: 'https://www.parkersoftware.com/wp-content/uploads/2020/10/pankaj-patel-_SgRNwAVNKw-unsplash-scaled.jpg'
            },
            {
              title: '#BCE29E',
              text: '',
              img: '',
              bg: '#BCE29E'
            },
            {
              title: '#DEF5E5',
              text: '',
              img: '',
              bg: '#DEF5E5'
            },
            {
              title: '#BCEAD5',
              text: '',
              img: '',
              bg: '#BCEAD5'
            },
            {
              title: '#9ED5C5',
              text: '',
              img: '',
              bg: '#9ED5C5'
            },
            {
              title: '#8EC3B0',
              text: '',
              img: '',
              bg: '#8EC3B0'
            },
          ]
        },
        {
          id: 2,
          title: '#B1B2FF',
          img: '',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#B1B2FF',
              text: '',
              img: '',
              bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1'
            },
            {
              title: '#D2DAFF',
              text: '',
              img: '',
              bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1'
            },
            {
              title: '#EEF1FF',
              text: '',
              img: '',
              bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1'
            }
          ]
        },
        {
          id: 3,
          title: '#D7C0AE',
          img: '',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#D7C0AE',
              text: '',
              img: '',
              bg: '#D7C0AE'
            },
          ]
        },
        {
          id: 4,
          title: '#FFB3B3',
          img: '',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#FFB3B3',
              text: '',
              img: '',
              bg: '#FFB3B3'
            },
            {
              title: '#FFE9AE',
              text: '',
              img: '',
              bg: '#FFE9AE'
            },
            {
              title: '#C1EFFF',
              text: '',
              img: '',
              bg: '#C1EFFF'
            }
          ]
        },
        {
          id: 5,
          title: '#C4DFAA',
          img: '',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#C4DFAA',
              text: '',
              img: '',
              bg: '#C4DFAA'
            },
            {
              title: '#90C8AC',
              text: '',
              img: '',
              bg: '#90C8AC'
            },
            {
              title: '#73A9AD',
              text: '',
              img: '',
              bg: '#73A9AD'
            }
          ]
        },
        {
          id: 6,
          title: '#F2D7D9',
          img: '',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#F2D7D9',
              text: '',
              img: '',
              bg: '#F2D7D9'
            },
            {
              title: '#9CB4CC',
              text: '',
              img: '',
              bg: '#9CB4CC'
            },
            {
              title: '#748DA6',
              text: '',
              img: '',
              bg: '#748DA6'
            }
          ]
        },
        {
          id: 7,
          title: '#9ADCFF',
          img: '',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#9ADCFF',
              text: '',
              img: '',
              bg: '#9ADCFF'
            },
            {
              title: '#FFB2A6',
              text: '',
              img: '',
              bg: '#FFB2A6'
            },
            {
              title: '#FF8AAE',
              text: '',
              img: '',
              bg: '#FF8AAE'
            }
          ]
        },
      ],
      storyIndex: null,
      isStoriesActive: false,
    }
  },

  actions: {
    showStory(boolean) {
      this.isStoriesActive = boolean;
    }
  }

})
