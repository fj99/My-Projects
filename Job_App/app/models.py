from app import db, login
from flask_login import UserMixin
from werkzeug.security import generate_password_hash, check_password_hash
from sqlalchemy.sql import func
from sqlalchemy.ext.declarative import declarative_base

class User(UserMixin, db.Model):
    __tablename__ = 'user'
    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(64), unique=True)
    email = db.Column(db.String(64), unique=True)
    fname = db.Column(db.String(64), nullable=False)
    lname = db.Column(db.String(64), nullable=False)
    phone_number = db.Column(db.String(10))
    role = db.Column(db.String(64), nullable=False)
    password_hash = db.Column(db.String(256), nullable=False)
    blocked = db.Column(db.Boolean, nullable=False)

    def set_password(self, password):
        # Store hashed (encrypted) password in database
        self.password_hash = generate_password_hash(password)

    def check_password(self, password):
        return check_password_hash(self.password_hash, password)

@login.user_loader
def load_user(id):
    return db.session.query(User).get(int(id))

class job_posting(db.Model):
    __tablename__ = 'job_posting'
    jobid = db.Column(db.Integer, primary_key=True)
    position = db.Column(db.Text(64), nullable=False)
    begin_time = db.Column(db.DateTime(timezone=True), server_default= func.now())
    end_time = db.Column(db.DateTime(timezone=True), nullable=False)
    user = db.Column(db.String(64), db.ForeignKey('user.id'))
    company = db.Column(db.String(64), nullable=False)

    def __repr__(self):
        return '{}'.format(self.jobid)

_DeclarativeBase = declarative_base()
class applicants(db.Model, _DeclarativeBase): 
    __tablename__ = 'applicants'
    postid = db.Column(db.Integer, primary_key=True)
    JpostID = db.Column(db.Integer,  db.ForeignKey('job_posting.jobid'), nullable=False)
    information = db.Column(db.String(4294967295), nullable=False)
    employee = db.Column(db.String(64), db.ForeignKey('user.id'), nullable=False)
    address = db.Column(db.String(100), nullable=False)
    fileName = db.Column(db.String(50))
    resume = db.Column(db.LargeBinary)

    def __repr__(self):
        return '{}'.format(self.postid)
