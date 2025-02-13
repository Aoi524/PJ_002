FROM python:3.13.1-slim

WORKDIR /flaskr

COPY requirements.txt .
RUN pip install -r requirements.txt

CMD [ "python", "app.py" ]