import React, { Component } from "react";
import Slide from "react-reveal";
import { Tooltip } from "react-tooltip";

class Resume extends Component {
  constructor(props) {
    super(props);

    // Set the initial state
    this.state = {
      images: [],
      rowCount: 3, // Default to 3 rows (you can change this to any value)
    };

    this.speed = 2; // Movement speed
    this.imageWidth = 100; // Adjust based on actual image size
    this.imageHeight = 100; // Adjust based on actual image height (same for all images)
  }

  componentDidMount() {
    // Make sure the data is passed down via props and then process it
    const allImages = this.props.data?.skills?.map((skill) => skill.link) || [];

    // Update state with the images after component mounts
    this.setState({
      images: allImages.map((src, index) => ({
        id: index,
        left: Math.random() * window.innerWidth, // Random start position
        src, // Store the image source (link)
      })),
    });

    this.interval = setInterval(this.moveImages, 16); // Smooth movement
  }

  componentWillUnmount() {
    clearInterval(this.interval);
  }

  moveImages = () => {
    this.setState((prevState) => ({
      images: prevState.images.map((img) => {
        let newLeft = img.left + this.speed;
        if (newLeft > window.innerWidth) {
          newLeft = -this.imageWidth; // Move back to the left side
        }
        return { ...img, left: newLeft };
      }),
    }));
  };

  render() {
    console.log(this.props.data)
    if (!this.props.data) return null;

    const skillmessage = this.props.data.skillmessage;
    const work_title = this.props.data.work_title;
    const skills_title = this.props.data.skills_title;

    const work = this.props.data.work.map(function (work) {
      return (
        <div key={work.company}>
          <h3 className="white">{work.company}</h3>
          <p className="info off-white">
            {work.title}
            <span>&bull;</span> <em className="date">{work.years}</em>
          </p>
          <p className="off-white">{work.description}</p>
        </div>
      );
    });

    const { images, rowCount } = this.state;

    // Calculate how many images per row
    const imagesPerRow = Math.ceil(images.length / rowCount);

    // Calculate vertical spacing (top position) for each row
    const rowHeight = this.imageHeight + 20; // Extra spacing between rows (20px)


    return (
      <section id="resume">
        <Slide left duration={1300}>
          <div className="row work">
            <div className="three columns header-col">
              <h1 className="white">
                <span>{work_title}</span>
              </h1>
            </div>

            <div className="nine columns main-col">{work}</div>
          </div>
        </Slide>

        <Slide left duration={1300}>
          <div className="row skill">
            <div className="three columns header-col">
              <h1 className="white">
                <span>{skills_title}</span>
              </h1>
            </div>

            <div className="nine columns main-col">
              <p>{this.props.skillmessage}</p>

              <div className="bars">
                <ul className="skills">

                  <div
                    style={{
                      position: "relative",
                      width: "100%",
                      height: `${rowCount * rowHeight}px`, // Set the height based on row count
                      overflow: "hidden",
                    }}
                  >
                    {images.map((img, index) => {
                      // Calculate the row number based on index and the number of rows
                      const rowIndex = Math.floor(index / imagesPerRow);
                      const topPosition = rowIndex * rowHeight; // Vertical position

                      return (
                        <img
                          key={img.id}
                          src={img.src} // Use the link from props as the image source
                          alt=""
                          style={{
                            position: "absolute",
                            left: img.left,
                            top: topPosition,
                            transform: "translateY(-50%)",
                            width: `${this.imageWidth}px`,
                            height: `${this.imageHeight}px`,
                            border: "2px solid red",
                          }}
                        />
                      );
                    })}
                  </div>

                </ul>
              </div>
            </div>


          </div>
        </Slide>
      </section >
    );
  }
}



export default Resume;
