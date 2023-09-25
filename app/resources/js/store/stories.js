// data fake
import { defineStore } from 'pinia';
import {fetchMyStories} from '../api/story.js';

export const useStoriesStore = defineStore('stories', {
  state: () => {
    return {
      stories: [
        {
          id: 1,
          title: 'hieptvh',
          img: '',
          username:'hieptvh',
          bg: 'https://images.pexels.com/photos/1229861/pexels-photo-1229861.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260', // avayar user
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
          ]
        },
        {
          id: 2,
          title: '#B1B2FF',
          img: '',
          username:'hieptvh',
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
          username:'hieptvh',
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
          username:'hieptvh',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#FFB3B3',
              text: '',
              img: '',
              bg: '#FFB3B3'
            },
          ]
        },
        {
          id: 5,
          title: '#C4DFAA',
          img: '',
          username:'hieptvh',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#C4DFAA',
              text: '',
              img: '',
              bg: '#C4DFAA'
            },
          ]
        },
        {
          id: 6,
          title: '#F2D7D9',
          img: '',
          username:'hieptvh',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#F2D7D9',
              text: '',
              img: '',
              bg: '#F2D7D9'
            },
          ]
        },
        {
          id: 7,
          title: '#9ADCFF',
          img: '',
          username:'hieptvh',
          bg: 'https://th.bing.com/th/id/OIP.cCdSJ0mOqjQkm-soL5hlIwHaFj?pid=ImgDet&w=3353&h=2514&rs=1',
          storiesGroup: [
            {
              title: '#9ADCFF',
              text: '',
              img: '',
              bg: '#9ADCFF'
            },
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
    },

    // my stories
    async fetchMyStories (){
      const response = await fetchMyStories();
      // console.log(response);
      // this.stories = response.data.stories;
    }
  }

})
