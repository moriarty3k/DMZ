from flask import Flask, request, session, g, redirect, url_for, abort, render_template, flash, Response
from jinja2 import Environment
from datetime import date



app = Flask(__name__)
Jinja2 = Environment()
#app.config.from_pyfile('config.py')


@app.route("/gen_vcard", methods=['POST'])
def gen_vcard():
    name = request.values.get('name')
    if(name is None): name = "Skibidi Toilet"
    org  = request.values.get('org')
    phone = request.values.get('phone')
    email = request.values.get('email')

    d = date.today()
    output = Jinja2.from_string("""BEGIN:VCARD
    VERSION:2.1
    N:{{ name.split(" ") | join(";") }}
    FN:{{ name }}
    ORG:{{ org }}
    TEL;WORK;VOICE:"""+phone+"""
    EMAIL:{{ email }}
    REV:{{ today.isoformat() }}
    END:VCARD""").render(name=name, org=org, email=email, today=d)
    
    # Instead, the variable should be passed to the template context.
    # Jinja2.from_string('Hello {{name}}!').render(name = name)

    return output, 200, {'Content-Disposition': 'attachment; filename='+(name.replace(" ","_"))+".vcf"}
@app.route("/gen_vcard", methods=['GET'])
def redirect():
    return render_template('index.html')

@app.route("/")
def index():
    return render_template('index.html')


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=1337)