from flask import Flask

# New imports
from flask_sqlalchemy import SQLAlchemy
from flask_login import LoginManager
from dotenv import load_dotenv
from os import environ
import mysql.connector
from flask_moment import Moment
from flask_bootstrap import Bootstrap
from flask_mail import Mail, Message

# force loading of environment variables
load_dotenv('.flaskenv')

# Get the environment variables from .flaskenv
IP = environ.get('MYSQL_IP')
USERNAME = environ.get('MYSQL_USER')
PASSWORD = environ.get('MYSQL_PASS')
DB_NAME = environ.get('MYSQL_DB')
MAIL_USERNAME = environ.get('MAIL_USERNAME')
MAIL_APP_PASSWORD = environ.get('MAIL_APP_PASSWORD')
MAIL_SENDER_NAME = environ.get('MAIL_SENDER_NAME')

app = Flask(__name__)
app.config['SECRET_KEY'] = 'csc33O'

# Specify the connection parameters/credentials for the database
DB_CONFIG_STR = f"mysql+mysqlconnector://{USERNAME}:{PASSWORD}@{IP}/{DB_NAME}"
app.config['SQLALCHEMY_DATABASE_URI'] = DB_CONFIG_STR
app.config["SQLALCHEMY_TRACK_MODIFICATIONS"]= True

#mail config
app.config.update(
        MAIL_SERVER = 'smtp.gmail.com',
        MAIL_PORT = 465,
        MAIL_USE_TLS = False,
        MAIL_USE_SSL = True,
        MAIL_USERNAME = MAIL_USERNAME,
        MAIL_PASSWORD = MAIL_APP_PASSWORD,
        MAIL_DEFAULT_SENDER = (MAIL_SENDER_NAME, MAIL_USERNAME),
        SECRET_KEY = 'some secret key for CSRF')
        
#mail func
mail = Mail(app)
moment = Moment(app)
bootstrap = Bootstrap(app)

# Create database connection and associate it with the Flask application
db = SQLAlchemy(app)

login = LoginManager(app)

# enables @login_required
login.login_view = 'login'

# Add models
from app import routes, models
from app.models import User, job_posting, applicants

# Create DB schema
db.create_all()
