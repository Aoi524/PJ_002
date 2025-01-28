from flask import Flask, render_template, request, redirect, url_for
import sqlite3

app = Flask(__name__)

DATABASE = 'database.db'

def create_blogs_table():
    con = sqlite3.connect(DATABASE)
    con.execute("CREATE TABLE IF NOT EXISTS blogs (title, body, post_date)")
    con.close()

create_blogs_table()

@app.route('/')
def index():
    con = sqlite3.connect(DATABASE)
    db_blogs = con.execute('SELECT * FROM blogs').fetchall()
    con.close()

    blogs = []
    for row in db_blogs:
        blogs.append({'title': row[0], 'body': row[1], 'post_date': row[2]})

    return render_template('index.html', blogs=blogs)
    
@app.route('/form')
def form():
    return render_template('form.html')

@app.route('/register', methods=['POST'])
def register():
    title = request.form['title']
    body = request.form['body']
    post_date = request.form['post_date']

    con = sqlite3.connect(DATABASE)
    con.execute('INSERT INTO blogs VALUES (?, ?, ?)', [title, body, post_date])
    con.commit()
    con.close()

    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(host="0.0.0.0", debug=True)