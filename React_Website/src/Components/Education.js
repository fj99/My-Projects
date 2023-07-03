import React, { Component } from "react";
import { Swiper, SwiperSlide } from 'swiper/react';
import 'swiper/swiper-bundle.css';
import Slide from "react-reveal";
import Fade from "react-reveal";
import SwiperCore, { Autoplay, Navigation, Pagination } from 'swiper';

// Install Swiper modules
SwiperCore.use([Autoplay, Navigation, Pagination]);

class Education extends Component {
  render() {
    if (!this.props.data) return null;

    const name = this.props.data.name;

    const educationSlides = this.props.data.education.map(function (education) {
      return (
        <SwiperSlide key={education.school}>
          <div className="center">
            <img
              className="edu-pic"
              src={education.image}
              alt="education-logo"
            />
            <h2 className="white">{education.school}</h2>
            <h4 className="off-white">{education.degree}</h4>
            <h5 className="off-white">{education.comment}</h5>
            <p className="info">
              {education.description}
            </p>
          </div>
        </SwiperSlide>
      );
    });

    return (
      <header id="edu">

        <div className="banner">
          <Slide left duration={1300}>
            <Swiper
              slidesPerView={1}
              autoplay={{ delay: 3000, disableOnInteraction: false }}
              loop={true}
              navigation
              pagination={{ clickable: true }}
              className={'custom-swiper'}
            >
              {educationSlides}
            </Swiper>
          </Slide>
        </div>
      </header>
    );
  }
}

export default Education;
