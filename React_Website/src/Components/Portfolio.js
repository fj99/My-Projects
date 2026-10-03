import React, { Component } from "react";
import Fade from "react-reveal";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import CardMedia from "@mui/material/CardMedia";
import Typography from "@mui/material/Typography";
import { CardActionArea, CardActions, IconButton } from "@mui/material";
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import Collapse from "@mui/material/Collapse";
import { createTheme, styled, ThemeProvider } from "@mui/material/styles";
import ProjectReadme from "./ProjectReadme";
import {
  getProjectReadmeKey,
  isExternalProjectUrl,
} from "../projectContent";

const theme = createTheme();


class Portfolio extends Component {
  constructor(props) {
    super(props);
    this.state = {
      expandedProjectKey: null,
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

  handleExpandClick = (projectKey) => {
    this.setState((prevState) => ({
      expandedProjectKey:
        prevState.expandedProjectKey === projectKey ? null : projectKey,
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
      const projectKey = getProjectReadmeKey(project);
      const href = isExternalProjectUrl(project.url)
        ? project.url
        : `#project/${encodeURIComponent(projectKey)}`;
      const isExpanded = this.state.expandedProjectKey === projectKey;

      return (
        <Card key={project.id || project.title} className="portfolio-card">
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
                image={`${import.meta.env.BASE_URL}${project.image}`}
                alt={project.title}
              />
              <CardContent className="portfolio-card-title">
                <Typography variant="h5" component="h2">
                  {project.title}
                </Typography>
              </CardContent>
            </CardActionArea>
          </a>
          <CardActions className="portfolio-card-footer">
            <div className="project-meta">
              <span>{project.category}</span>
              <span>{project.date}</span>
            </div>
            <ExpandMore
              expand={isExpanded}
              onClick={() => this.handleExpandClick(projectKey)}
              aria-expanded={isExpanded}
              aria-label={`Show details for ${project.title}`}
            >
              <ExpandMoreIcon className="custom-expand" />
            </ExpandMore>
          </CardActions>
          <Collapse in={isExpanded} timeout="auto" unmountOnExit>
            <CardContent className="portfolio-description">
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
                <div className="section-heading">
                  <p className="section-eyebrow">Selected work</p>
                  <h2>{portfolio_title}</h2>
                  <p>Explore the systems, applications, and data projects I&apos;ve built.</p>
                </div>
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
