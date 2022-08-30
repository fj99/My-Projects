import datetime
from email import message
from multiprocessing import log_to_stderr
from attr import validate
from app import app
from io import BytesIO
from flask_mail import Mail, Message
from datetime import date
from flask import Flask, render_template,  redirect, url_for, session, request, send_file
from flask_login import login_user, logout_user, login_required, current_user
from werkzeug.security import check_password_hash, generate_password_hash
from app.forms import SearchUser, LoginForm, AddUserForm, ChangePasswordForm, JobRequest, Jobapply, SendEmail, VerifyEmail, ResetEmail
from app import db
from app.models import User, job_posting, applicants
import sys
import random
import string

mail = Mail(app)
# app = Flask(__name__)
lost = ''
key = ''


@app.route('/')
def index():
    session['name'] = 'not logged in'
    if current_user.is_authenticated:
        session['name'] = current_user.fname + ' ' + current_user.lname
        return render_template('index.html')
    return render_template('index.html')


@app.route('/login', methods=['GET', 'POST'])
def login():
    # Authenticated users are redirected to home page.
    if current_user.is_authenticated:
        return redirect(url_for('index'))
    form = LoginForm()
    if form.validate_on_submit():
        # Query DB for user by username
        users = db.session.query(User).filter_by(
            username=form.username.data).first()
        if users is None or not users.check_password(form.password.data):
            print('Login failed', file=sys.stderr)
            return redirect(url_for('login'))
        login_user(users)
        # login_user is a flask_login function that starts a session
        print('Login successful', file=sys.stderr)
        return redirect(url_for('index'))
    return render_template('login.html', form=form)


@app.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('index'))


@app.route('/check/<name>/<fname>/<lname>/<email>/<number>/<role>/<pas>', methods=['GET', 'POST'])
def check(name, fname, lname, email, number, role, pas):
    form = check
    form = VerifyEmail()
    if not form.validate_on_submit():
        letters = string.ascii_lowercase
        global key
        key = ''.join(random.choice(letters) for i in range(10))
        subject = 'Verify Email'
        message = '''
        <h1> Collaborative Information Center </h1>
            This is a message to {fname} {lname} from Collaborative Information Center <br>
            to test your email enter this token in the website: <br>
            <h1>{key}</h1>
        '''.format(fname=fname, lname=lname, key=key)

        msg = Message(subject, recipients=[email], html=message)
        mail.send(msg)
    else:
        token = form.token.data

        print('key:', key)
        print('input:', token)

        if token != key:
            session['error'] = 'Re-Enter token check Email'
            return redirect(url_for('check', name=name, fname=fname, lname=lname, email=email, number=number, role=role, pas=pas))
        elif token == key:
            pass

        user = db.session.query(User).filter_by(username=name).first()
        if user is None:
            subject = 'Welcome to Collaborative Information Center'
            message = '''
                Welcome to Collaborative Information Center {fname} {lname} <br>            
                Your username is {username} <br>
                Your phone number is {number} <br>
                You signed up as a {role} <br>
            '''.format(fname=fname, lname=lname, username=name, number=number, role=role)

            msg = Message(subject, recipients=[email], html=message)
            mail.send(msg)

            new = User(username=name, email=email, role=role, fname=fname,
                       lname=lname, phone_number=number, blocked=False)
            new.set_password(pas)
            db.session.add(new)
            db.session.commit()
            print('user created successfully')
            return redirect(url_for('index'))
        else:
            session['error'] = 'Username already exists'
            print('Username or email already exists')
            return redirect(url_for('register'))
    return render_template('verify.html', form=form)


@app.route('/register', methods=['GET', 'POST'])
def register():
    if current_user.is_authenticated:
        return redirect(url_for('index'))
    session['error'] = ''
    form = AddUserForm()
    if form.validate_on_submit():
        name = form.username.data
        fname = form.fname.data
        lname = form.lname.data
        email = form.email.data
        number = form.phone.data
        role = form.role.data
        pas = form.password.data
        # Query database to check username and email exist

        em = db.session.query(User).filter_by(email=email).first()

        if em is None:
            return redirect(url_for('check', name=name, fname=fname, lname=lname, email=email, number=number, role=role, pas=pas))
        else:
            session['error'] = "email already exists"
    return render_template('register.html', form=form, login=login)


@app.route('/Jrequest', methods=['GET', 'POST'])
@login_required
def Jrequest():
    form = JobRequest()
    if form.validate_on_submit():
        name = current_user.id
        pos = form.position.data
        end = form.end_date.data
        comp = form.company.data

        email = current_user.email
        fname = current_user.fname
        lname = current_user.lname
        today = today = date.today()
        subject = 'Job Request for {pos}'.format(pos=pos)
        message = '''
            <h1>Collaborative Information Center</h1><br>
                This is a message to {fname} {lname} from Collaborative Information Center letting you know about job
                Company name is {comp}<br>
                This job was posted on {today}<br>
                This job will expire on {end} meaning noone will be alowed to apply afterwards.
            '''.format(fname=fname, lname=lname, comp=comp, today=today, end=end)

        msg = Message(subject, recipients=[email], html=message)
        mail.send(msg)

        p = job_posting(position=pos, end_time=end, user=name, company=comp)

        db.session.add(p)
        db.session.commit()

        return redirect(url_for('Jrequest'))
    return render_template('request.html', form=form)


@app.route('/apply/<id>', methods=['GET', 'POST'])
@login_required
def apply(id):
    form = apply
    session['id'] = id
    if request.method == 'POST':
        res = request.files['file']
        inf = request.form['info']
        add = request.form.get('address')

        job = db.session.query(job_posting).filter_by(jobid=id).first()
        host = db.session.query(User).filter_by(id=job.user).first()
        comp = job.company
        pos = job.position
        end = job.end_time
        end = end.date()
        email = host.email
        fname = current_user.fname
        lname = current_user.lname
        today = today = date.today()
        subject = '{pos}'.format(pos=pos)
        message = '''
                <h1>Collaborative Information Center</h1><br>
                This is a message to {hfname} {hlname} from Collaborative Information Center,
                to let you know that {fname} {lname} is applying to this job 
                From this comapny {comp}.<br>
                This user applied to this job on {today}.<br>
                This job will expire on {end} meaning no one will be alowed to apply afterwards.
            '''.format(fname=fname, lname=lname, today=today, end=end, hfname=host.fname, hlname=host.lname, comp=comp)

        msg = Message(subject, recipients=[email], html=message)
        mail.send(msg)

        a = applicants(JpostID=id, information=inf, employee=current_user.id,
                       address=add, fileName=res.filename, resume=res.read())

        db.session.add(a)
        db.session.commit()
        return redirect(url_for('index'))

    return render_template('apply.html', form=form)


@app.route('/jobs', methods=['GET', 'POST'])
@login_required
def jobs():
    form = jobs
    current_time = datetime.datetime.utcnow()
    data = job_posting.query.with_entities(
        job_posting.position, job_posting.begin_time, job_posting.end_time, job_posting.company, job_posting.jobid)
    session['role'] = current_user.role
    session['now'] = current_time
    if request.method == 'POST':
        if request.form.get('jobID') != 0:
            x = (request.form.get('jobID'))
            id = int(x)
            return redirect(url_for('apply', id=id))
    else:
        return render_template('jobs.html', form=form, data=data)
    return render_template('jobs.html', data=data)


@app.route('/change_password', methods=['GET', 'POST'])
@login_required
def change_password():
    form = ChangePasswordForm()
    if form.new_pass.data == form.new_pass_retype.data:
        if form.validate_on_submit():
            users = db.session.query(User).filter_by(
                role=current_user.role).first()
            check_pass = users.check_password(form.old_pass.data)
            if check_pass:
                users.set_password(form.new_pass.data)
                db.session.commit()
                print('Password changed successfully', file=sys.stderr)
                return redirect(url_for('index'))
            else:
                print('Wrong Password Change failed', file=sys.stderr)
                return redirect(url_for('change_password'))
    else:
        print('new password not the same', file=sys.stderr)
        return redirect(url_for('change_passsword'))
    return render_template('change_password.html', form=form)


@app.route('/applications', methods=['GET', 'POST'])
@login_required
def applications():
    job_data = []
    if current_user.is_authenticated:
        if current_user.role == 'admin':
            job_data = db.session.query(job_posting).all()
            return render_template("applications.html", data=job_data)
        else:
            job_data = db.session.query(job_posting).filter_by(
                user=current_user.id).all()
            return render_template("applications.html", data=job_data)
    return render_template('invalid_access.html')


@app.route('/view_applications', methods=['GET', 'POST'])
@login_required
def view_applications():
    form = apply
    session['id'] = request.form.get("jobid")
    id = request.form.get("jobid")
    try:
        if request.form['view'] == 'View Applications':
            job_applications = db.session.query(applicants, User).select_from(
                applicants).filter_by(JpostID=id).join(User, User.id == applicants.employee).all()
            job_post = db.session.query(
                job_posting).filter_by(jobid=id).first()
            return render_template('job_applications.html', data=job_applications, post=job_post.position)
    except KeyError:
        pass
    if request.form['delete'] == 'Delete':
        db.session.query(job_posting).filter_by(jobid=id).delete()
        db.session.query(applicants).filter_by(JpostID=id).delete()
        db.session.commit()
        return redirect(url_for('index'))
    return "Error"


@app.route('/resume/<index>', methods=['GET', 'POST'])
@login_required
def resume(index):
    file = db.session.query(applicants).filter_by(postid=index).first()
    return send_file(BytesIO(file.resume), attachment_filename=file.fileName, as_attachment=True)


@app.route('/mail', methods=['GET', 'POST'])
def send_mail():
    mail_form = SendEmail()
    if mail_form.validate_on_submit() or request.method == 'POST':
        name = request.form['name']
        recipient = mail_form.email.data
        message = mail_form.message.data
        subject = "Suggestion or Report from {n}".format(n=name)
        # message = "<h1>Testing</h1> <br> key"

        msg = Message(subject, recipients=[recipient], html=message)
        mail.send(msg)
        mail_form.email.data = ''
        mail_form.message.data = ''
        return redirect(url_for('index'))
    return render_template('mail.html', form=mail_form)


@app.route('/search', methods=['GET', 'POST'])
def search():
    form = SearchUser()
    session['error'] = ''
    if form.validate_on_submit() or request.method == 'POST':
        # make it search with spaces and for multiple columns
        search = '%{data}%'.format(data=form.user.data)
        record = db.session.query(User).filter(
            User.username.like(search)).all()
        if record:
            return render_template('view_users.html', users=record)
        else:
            session['error'] = 'no user found'
    return render_template('search.html', form=form)


@app.route('/verify', methods=['GET', 'POST'])
def verify():
    global lost
    form = ChangePasswordForm()
    if form.new_pass.data == form.new_pass_retype.data:
        if form.validate_on_submit():
            user = db.session.query(User).filter_by(id=lost).first()
            check_pass = user.check_password(form.old_pass.data)
            if check_pass:
                user.set_password(form.new_pass.data)
                db.session.commit()
                print('Password changed successfully', file=sys.stderr)
                return redirect(url_for('index'))
            else:
                print('Wrong Password Change failed', file=sys.stderr)
                return redirect(url_for('change_password'))
    else:
        print('new password not the same', file=sys.stderr)
        return redirect(url_for('change_passsword'))
    return render_template('change_password.html', form=form)


@app.route('/reset_password', methods=['GET', 'POST'])
def reset_password():
    letters = string.ascii_lowercase
    form = ResetEmail()
    session['error'] = ''
    if form.validate_on_submit() or request.method == 'POST':
        email = form.email.data
        users = db.session.query(User).filter_by(email=email).all()
        user = db.session.query(User).filter_by(email=email).first()

        if users:
            global key
            key = ''.join(random.choice(letters) for i in range(10))

            user.set_password(key)
            db.session.commit()
            fname = user.fname
            lname = user.lname

            subject = 'Dream Beans password'
            message = '''
            <h1> Collaborative Information Center </h1>
                This is a message to {fname} {lname} from Collaborative Information Center <br>
                You forgot your password and it has now been reset to: <br>
                <h1>{key}</h1>
            '''.format(fname=fname, lname=lname, key=key)

            msg = Message(subject, recipients=[email], html=message)
            mail.send(msg)
            # switch routes
            global lost
            id = user.id
            lost = id
            # return redirect(url_for('verify', id=id))
            return redirect(url_for('verify'))
        else:
            session['error'] = 'no email found'
    return render_template('email_verify.html', form=form)
