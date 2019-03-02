import React from 'react';
import logo from 'assets/images/logo.png';
import './index.scss';

export default function About() {
  return (
    <div className="container pt-3">
      <div className="pb-4">
        <div className="title-font-large text-center">
          We keep market on track.
        </div>
        <p className="sub-title-font text-center">
          This is a testing project from ITechArt Students Lab developers team.
          We operate the Investors Exchange (IEX), a stock exchange for U.S.equities that is built for investors and companies.
        </p>
      </div>
      <div className="pt-2">
        <div className="title-font-medium text-center mb-3">
          The ITechArt team story
        </div>
        <div className="row justify-content-md-center">
          <div className="col-2 align-self-center">
            <div className="title-font-small title-small-mg mr-3">
              <div className="text-center">2018</div>
              <div className="text-center border-bottom">Founded</div>
            </div>
            <div className="title-font-small mr-3">
              <div className="text-center">7</div>
              <div className="text-center border-bottom">Participants</div>
            </div>
          </div>
          <div className="col-5 align-self-center p-bg pt-3 ml-4">
            <div className="p-text">
              <p>
                While working at the Royal Bank of Canada (RBC), the global
                electronic trading team led by Brad Katsuyama, Ronan Ryan, John
                Schwall, and Rob Park discovered an uneven playing field in the
                stock market. Seeing that inequality, they took on the challenge
                to level the playing field for long-term investors such as mutual funds and pension funds.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div className="pt-2">
        <div className="title-font-medium text-center pt-5 pb-2 mb-3">
          Developers
        </div>
        <div className="row justify-content-md-center">
          <div className="col-2">
            <div className="pic-font-small mb-1 text-center">
              Alex Filipovsky
            </div>
            <div className="h-100">
              <img className="w-100 rounded" src={logo} alt="Logo" />
            </div>
          </div>
          <div className="col-2">
            <div className="pic-font-small mb-1 text-center">
              Kirill Karazhan
            </div>
            <div className="h-100">
              <img className="w-100" src={logo} alt="Logo" />
            </div>
          </div>
          <div className="col-2">
            <div className="pic-font-small mb-1 text-center">
              Egor Dubrovsky
            </div>
            <div className="h-100">
              <img className="w-100" src={logo} alt="Logo" />
            </div>
          </div>
          <div className="col-2">
            <div className="pic-font-small mb-1 text-center">
              Vlad Dolgoshey
            </div>
            <div className="h-100">
              <img className="w-100" src={logo} alt="Logo" />
            </div>
          </div>
        </div>
        <div className="title-font-medium text-center pt-5 pb-2 mb-3">
          Mentors
        </div>
        <div className="row justify-content-md-center pb-5">
          <div className="col-2">
            <div className="pic-font-small mb-1 text-center">Artyom</div>
            <div className="h-100">
              <img className="w-100" src={logo} alt="Logo" />
            </div>
          </div>
          <div className="col-2">
            <div className="pic-font-small mb-1 text-center">Pavel</div>
            <div className="h-100">
              <img className="w-100" src={logo} alt="Logo" />
            </div>
          </div>
          <div className="col-2">
            <div className="pic-font-small mb-1 text-center">Sergey</div>
            <div className="h-100">
              <img className="w-100" src={logo} alt="Logo" />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
