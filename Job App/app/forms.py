from email.headerregistry import Address
from fileinput import filename
from flask_wtf import FlaskForm
from wtforms.fields import DateField
from wtforms import StringField, FileField, SubmitField, PasswordField, validators, SelectField, TextAreaField, IntegerField
from wtforms.validators import DataRequired
from app.models import User, job_posting, applicants

class LoginForm(FlaskForm):
    username = StringField('Username', validators=[DataRequired()])
    password = PasswordField('Password', validators=[DataRequired()])
    submit = SubmitField('Submit')

class AddUserForm(FlaskForm):
    fname = StringField('First Name', validators=[DataRequired()])
    lname = StringField('Last Name', validators=[DataRequired()])
    username = StringField('Username', validators=[DataRequired()])
    phone = StringField('Telephone', validators=[DataRequired()])
    role = SelectField('Role', choices = ['employer','employee'], validators = [DataRequired()])
    StringField('Role', validators=[DataRequired()])
    email = StringField('Email', validators=[DataRequired()])
    password = PasswordField('Password', validators=[DataRequired()])
    submit = SubmitField('Submit')

class VerifyEmail(FlaskForm):
    token = StringField('Enter Token', validators=[DataRequired()])
    submit = SubmitField('Submit')
    
class JobRequest(FlaskForm):
    position = StringField('Position for the job', validators=[DataRequired()])
    company = StringField('Company name', validators=[DataRequired()])
    end_date = DateField('End Date', format='%Y-%m-%d', validators=[DataRequired()]) 
    submit = SubmitField('Submit')

class Jobapply(FlaskForm):
    address =  StringField('Address', validators=[DataRequired()])
    post = TextAreaField("Information about yourself:",validators=[DataRequired()])
    resume =  FileField('Resume:', validators=[DataRequired()]) 
    submit = SubmitField('Post')

class ChangePasswordForm(FlaskForm):
    old_pass = PasswordField('Old password', validators=[DataRequired()])
    new_pass = PasswordField('New password', validators=[DataRequired()])
    new_pass_retype = PasswordField('Retype new password', validators=[DataRequired()])
    submit = SubmitField('Change password')

class SearchUser(FlaskForm):
    user = StringField('Username:', validators=[DataRequired()])
    submit = SubmitField('Search')

class SendEmail(FlaskForm):
    email = StringField('Recipient: ', validators=[DataRequired()])
    message = TextAreaField('Your message:', validators=[DataRequired()])
    # message = StringField('Your message:', validators=[DataRequired()])
    submit = SubmitField('Send')

class ResetEmail(FlaskForm):
    email = StringField('Email', validators=[DataRequired()])
    submit = SubmitField('Send')
