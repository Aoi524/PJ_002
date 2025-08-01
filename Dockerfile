FROM python:3.12.0

WORKDIR /flask-todo

COPY requirements.txt .
RUN pip install -r requirements.txt

CMD [ "python", "app.py" ]