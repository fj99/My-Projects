import React, { Component } from "react";
import { Swiper, SwiperSlide } from 'swiper/react';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import Slide from "react-reveal";

class Education extends Component {
  render() {
    if (!this.props.data) return null;

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
              modules={[Autoplay, Navigation, Pagination]}
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
