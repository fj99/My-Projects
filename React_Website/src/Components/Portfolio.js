import React, { Component } from "react";
import { styled, ThemeProvider } from "@mui/system";
import Fade from "react-reveal";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import CardMedia from "@mui/material/CardMedia";
import Typography from "@mui/material/Typography";
import { Button, CardActionArea, CardActions, IconButton } from "@mui/material";
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import Collapse from "@mui/material/Collapse";
import { createTheme } from "@mui/material/styles";
import ProjectReadme, {
  getProjectReadmeKey,
  isExternalProjectUrl,
} from "./ProjectReadme";

const theme = createTheme();


class Portfolio extends Component {
  constructor(props) {
    super(props);
    this.state = {
      expanded: false,
      selectedProjectKey: this.getSelectedProjectKey(),
    };
  }

  componentDidMount() {
    window.addEventListener("hashchange", this.handleHashChange);
  }

  componentWillUnmount() {
    window.removeEventListener("hashchange", this.handleHashChange);
  }

  getSelectedProjectKey = () => {
    const match = window.location.hash.match(/^#project\/([^/]+)$/);
    return match ? decodeURIComponent(match[1]) : null;
  };

  handleHashChange = () => {
    const selectedProjectKey = this.getSelectedProjectKey();
    this.setState({ selectedProjectKey }, () => {
      if (window.location.hash === "#portfolio" || selectedProjectKey) {
        document.getElementById("portfolio")?.scrollIntoView({ block: "start" });
      }
    });
  };

  handleExpandClick = () => {
    this.setState((prevState) => ({
      expanded: !prevState.expanded,
    }));
  };

  handleProjectClick = (event, project) => {
    if (!project.url || isExternalProjectUrl(project.url)) {
      return;
    }

    event.preventDefault();
    window.location.hash = `project/${encodeURIComponent(getProjectReadmeKey(project))}`;
  };

  handleBackToProjects = () => {
    window.location.hash = "portfolio";
  };

  render() {
    if (!this.props.data) return null;

    const portfolio_title = this.props.data.portfolio_title;

    const ExpandMore = styled((props) => {
      const { expand, ...other } = props;
      return <IconButton {...other} />;
    })(({ expand }) => ({
      transform: !expand ? "rotate(0deg)" : "rotate(180deg)",
      marginLeft: "auto !important", marginRight: "0 !important",
      transition: theme.transitions.create("transform", {
        duration: theme.transitions.duration.shortest,
      }),
    }));

    const selectedProject = this.props.data.projects.find(
      (project) => getProjectReadmeKey(project) === this.state.selectedProjectKey
    );

    const projects = this.props.data.projects.map((project) => {
      const href = isExternalProjectUrl(project.url)
        ? project.url
        : `#project/${encodeURIComponent(getProjectReadmeKey(project))}`;

      return (
        <Card sx={{ maxWidth: 500 }} key={project.id || project.title} className="portfolio-card">
          <a
            className="Project_links"
            href={href}
            onClick={(event) => this.handleProjectClick(event, project)}
          >
            <CardActionArea className="img-wrapper">
              <CardMedia
                className="hover-zoom"
                component="img"
                height="140"
                image={project.image}
                alt={project.title}
              />
              <CardContent>
                <Typography gutterBottom variant="h5" component="div">
                  {project.title}
                </Typography>
              </CardContent>
            </CardActionArea>
          </a>
          <CardActions>
            <Button className="custom-btn" size="large" color="primary">
              {project.category} - {project.date}
            </Button>
            <ExpandMore
              expand={this.state.expanded}
              onClick={this.handleExpandClick}
              aria-expanded={this.state.expanded}
              aria-label="show more"
            >
              <ExpandMoreIcon className="custom-expand" />
            </ExpandMore>
          </CardActions>
          <Collapse in={this.state.expanded} timeout="auto" unmountOnExit>
            <CardContent>
              <Typography paragraph>{project.description}</Typography>
            </CardContent>
          </Collapse>
        </Card>
      );
    });

    return (
      <ThemeProvider theme={theme}>
        <section id="portfolio">
          <Fade left duration={1000} distance="40px">
            <div className="row">
              <div className="twelve columns collapsed">
                <h1 className="white">{portfolio_title}</h1>
                {selectedProject ? (
                  <ProjectReadme
                    project={selectedProject}
                    repository={this.props.data.repository}
                    onBack={this.handleBackToProjects}
                  />
                ) : (
                  <div className="portfolio-grid">{projects}</div>
                )}
              </div>
            </div>
          </Fade>
        </section>
      </ThemeProvider>
    );
  }
}

export default Portfolio;
